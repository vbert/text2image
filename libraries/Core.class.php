<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Core
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
class Core {

	/**
	 * @var object Instance Slug class
	 */
	protected $Slug;

	/**
	 * @var object Instance Session class
	 */
	protected $Session;

	/**
	 * @var string
	 */
	protected $controllers_path;

	/**
	 * @var string
	 */
	protected $views_path;

	/**
	 * @var string
	 */
	protected $user_project_path;

	/**
	 * @var array
	 */
	protected $default_objects = array(
		'AUTH', 'USER', 'PROJECT', 'USER_PROJECT'
	);

	/**
	 * @var array
	 */
	protected $objects;

	/**
	 * @var string
	 */
	protected $default_object;

	/**
	 * @var array
	 */
	protected $default_actions = array(
		'LOGIN', 'LOGOUT', 'DO_LOGIN',
		'LIST', 'DETAIL', 'ADD', 'EDIT', 'DELETE'
	);

	/**
	 * @var array
	 */
	protected $actions;

	/**
	 * @var string
	 */
	protected $default_action;

	/**
	 * @var array
	 */
	protected $navbar_items = array(
		'PROJECT_LIST' => array(
			'param_uri' => array('o=PROJECT', 'a=LIST'),
			'title' => 'Lista projektów',
			'active' => FALSE,
			'for_loggedin' => 2, // 0 - No, 1 - Yes, 2 - No & Yes
			'for_admin' => 2 // 0 - No, 1 - Yes, 2 - No & Yes
		),
		'AUTH_LOGIN' => array(
			'param_uri' => array('o=AUTH', 'a=LOGIN'),
			'title' => 'Zaloguj',
			'active' => FALSE,
			'for_loggedin' => 0,
			'for_admin' => 2
		),
		'AUTH_LOGOUT' => array(
			'param_uri' => array('o=AUTH', 'a=LOGOUT'),
			'title' => 'Wyloguj',
			'active' => FALSE,
			'for_loggedin' => 1,
			'for_admin' => 2
		)
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->Slug = new Slug();
		$this->Session = new Session();
		$this->set_controllers_path();
		$this->set_views_path();
		$this->set_objects();
		$this->set_actions();
	}

	/**
	 * Building a www address
	 * @param array $parameters
	 * @return string
	 */
	public function build_uri($parameters = array()) {
		return $this->_uri(BASEURI, $parameters);
	}

	/**
	 * Building a admin www address
	 * @param array $parameters
	 * @return string
	 */
	public function build_admin_uri($parameters = array()) {
		return $this->_uri(ADMINBASEURI, $parameters);
	}

	private function _uri($base_uri, $parameters = array()) {
		if (count($parameters) > 0) {
			$query_string = implode('&', $parameters);
			return $base_uri . '?' . $query_string;
		} else {
			return $base_uri;
		}
	}

	/**
	 * Building a controller file name
	 * @param array $parameters
	 * @return string
	 */
	public function build_controller_name($parameters = array()) {
		$default = 'project_list.php';
		if (count($parameters) > 0) {
			$name_string = implode('_', $parameters);
			return strtolower($name_string) . '.php';
		} else {
			return $default;
		}
	}

	/**
	 * Generate a hash
	 * @return string
	 */
	public function generate_hash($string_to_hash = '') {
		if (strlen($string_to_hash) > 0) {
			$unique_id = $string_to_hash;
		} else {
			$unique_id = uniqid(rand(), TRUE);
		}
		return hash('sha512', $unique_id);
	}

	/**
	 * Generate hash password and user
	 * @param string $user
	 * @param string $password
	 * @return string | boolean
	 */
	public function hash_password($user, $password) {
		if (strlen($user) > 0 && strlen($password) > 0) {
			$options = array(
				'cost' => 7,
				'salt' => $user . $password . $user,
			);
			$hash = password_hash($password, PASSWORD_DEFAULT, $options);
			return $hash;
		} else {
			return FALSE;
		}
	}

	/**
	 * Make hash for session
	 * @param string $hash_password
	 * @return string
	 */
	public function hash_user_to_session($hash_password) {
		return $this->_hash_perm($hash_password);
	}

	/**
	 * Make hash for one day
	 * @param string $string_to_hash
	 * @return string
	 */
	private function _hash_perm($string_to_hash) {
		$today = getdate();
		$salt = $today['year'] . $today['mon'] . $today['mday'];
		$options = array(
			'cost' => 7,
			'salt' => $salt . $salt . $salt . $salt,
		);
		$hash = password_hash($string_to_hash, PASSWORD_DEFAULT, $options);
		return $hash;
	}

	/**
	 * Check permissions
	 * @return boolean
	 */
	public function check_perm() {
		$perm = FALSE;

		$DBUsers = new \VbertTools\JSON_File(DBUSERS);
		$Users = $DBUsers->get(DBPATH, TRUE)[0];
		$session_user = $this->Session->get('user');

		if (array_key_exists($session_user['name'], $Users)) {
			$user = $Users[$session_user['name']];
			if ($this->hash_user_to_session($user['password']) === $session_user['hash']) {
				$perm = TRUE;
			}
		}

		return $perm;
	}

	/**
	 * Show login form
	 * @param string $next
	 */
	public function show_login_form($next = '') {
		$this->Session->del('user');
		$this->Session->set('loggedin', FALSE);
		$n = ($next) ? '&next=' . $next : '';
		header('Location: ' . URI_LOGIN . $n);
	}

	/**
	 * Logout
	 * @param string $next
	 */
	public function logout($next = '') {
		$this->Session->forget();
		if ($next) {
			header('Location: ' . $next);
		} else {
			header('Location: ' . URI_HOME);
		}
	}

	/**
	 * Set objects array
	 * @param array $objects
	 */
	public function set_objects($objects = array()) {
		if (count($objects) > 0) {
			$this->objects = $objects;
		} else {
			$this->objects = $this->default_objects;
		}
		$this->set_default_object('PROJECT');
	}

	/**
	 * Set default object
	 * @param string $object
	 */
	public function set_default_object($object) {
		if (strlen($object) > 0) {
			$this->default_object = $object;
		}
	}

	/**
	 * Get default object
	 * @return string
	 */
	public function get_default_object() {
		return $this->default_object;
	}

	/**
	 * Get current object or set defaul
	 * @return string
	 */
	public function get_current_object() {
		$default = $this->get_default_object();
		return $this->input('o', $default);
	}

	/**
	 * Check whether the given object is in the array
	 * @param string $object
	 * @return boolean
	 */
	public function in_objects($object) {
		return in_array($object, $this->objects, TRUE);
	}

	/**
	 * Set actions array
	 * @param array $actions
	 */
	public function set_actions($actions = array()) {
		if (count($actions) > 0) {
			$this->actions = $actions;
		} else {
			$this->actions = $this->default_actions;
		}
		$this->set_default_action('LIST');
	}

	/**
	 * Set default action
	 * @param string $action
	 */
	public function set_default_action($action) {
		if (strlen($action) > 0) {
			$this->default_action = $action;
		}
	}

	/**
	 * Get default action
	 * @return string
	 */
	public function get_default_action() {
		return $this->default_action;
	}

	/**
	 * Get current action or set defaul
	 * @return string
	 */
	public function get_current_action() {
		$default = $this->get_default_action();
		return $this->input('a', $default);
	}

	/**
	 * Check whether the given action is in the array
	 * @param string $action
	 * @return boolean
	 */
	public function in_actions($action) {
		return in_array($action, $this->actions, TRUE);
	}

	/**
	 * Set path to controllers files
	 * @param string $path
	 */
	public function set_controllers_path($path = CONTROLLERSPATH) {
		$this->controllers_path = $path;
	}

	/**
	 * Get path to controllers files
	 * @return string
	 */
	public function get_controllers_dir($subdir = '') {
		if (strlen($subdir) > 0) {
			$this->set_controllers_path(CONTROLLERSPATH . $subdir . DIRECTORY_SEPARATOR);
		}
		return $this->controllers_path;
	}

	/**
	 * Set path to views files
	 * @param string $path
	 */
	public function set_views_path($path = VIEWSPATH) {
		$this->views_path = $path;
	}

	/**
	 * Get path to views files
	 * @return string
	 */
	public function get_views_dir() {
		return $this->views_path;
	}

	/**
	 * Safe data
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function sanitize_data($key, $default = NULL) {
		$data = $this->input($key, $default);
		return htmlspecialchars(stripcslashes(trim($data)));
	}

	/**
	 * Receive data from the user, $_GET and $_POST
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function input($key, $default = NULL) {
		$options = array('flags' => FILTER_NULL_ON_FAILURE);
		$_get = filter_input(INPUT_GET, $key, FILTER_DEFAULT, $options);
		if ($_get === FALSE) {
			$_post = filter_input(INPUT_POST, $key, FILTER_DEFAULT, $options);
		} else {
			return $_get;
		}
		if ($_post !== FALSE) {
			return $_post;
		} else {
			return $default;
		}
	}

	/**
	 * Retrieves entire system arrays, $_GET, $_POST, $_COOKIE and $_SERVER
	 * @param string $type
	 * @param mixed $default
	 * @return array | boolean
	 */
	public function get_array($type = 'GET', $default = NULL) {
		$options = array('flags' => FILTER_NULL_ON_FAILURE);
		$return = FALSE;
		if (!is_null($default)) {
			$option = array('default' => $default);
			$options['options'] = $option;
			$return = $default;
		}
		switch ($type) {
			case 'GET':
				$return = filter_input_array(INPUT_GET);
				break;
			case 'POST':
				$return = filter_input_array(INPUT_POST);
				break;
			case 'COOKIE':
				$return = filter_input_array(INPUT_COOKIE);
				break;
			case 'SERVER':
				$return = filter_input_array(INPUT_SERVER);
				break;
			default:
				$return = FALSE;
				break;
		}
		return $return;
	}

	/**
	 * Print alert on page
	 * @param array | string $alert_text
	 * @param string $alert_type
	 * @param string $alert_title
	 * @return string | boolean
	 */
	public function alert($alert_text, $alert_type = ALERT_SUCCESS, $alert_title = FALSE) {
		if (is_array($alert_text)) {
			$a = $alert_text;
			return $this->set_alert($a['text'], $a['type'], $a['title']);
		} else {
			if (strlen($alert_text) > 0) {
				return $this->set_alert($alert_text, $alert_type, $alert_title);
			} else {
				return FALSE;
			}
		}
	}

	/**
	 * Set alert widget
	 * @param string $alert_text
	 * @param string $alert_type
	 * @param string $alert_title
	 * @return string
	 */
	private function set_alert($alert_text, $alert_type, $alert_title) {
		if ($alert_title) {
			$title = sprintf('<h4>%s</h4>', $alert_title);
		} else {
			$title = '';
		}
		$text = $alert_text;
		$type = $alert_type;
		$format = '<div class="%s" role="alert">%s<p>%s</p></div>';
		return sprintf($format, $type, $title, $text);
	}

	public function navbar($loggedin = FALSE, $admin = FALSE) {
		$object = $this->get_current_object();
		$action = $this->get_current_action();

		if (strlen($object) > 0 && strlen($action)) {
			$current = $object . '_' . $action;
		} else {
			$current = '';
		}

		if ($admin) {
			return $this->set_navbar_admin($current, $loggedin);
		} else {
			return $this->set_navbar_user($current, $loggedin);
		}
	}

	private function set_navbar_user($current, $loggedin) {
		return $this->get_navbar_items($current, $loggedin);
	}

	private function set_navbar_admin($current, $loggedin) {
		return $this->get_navbar_items($current, $loggedin, TRUE);
	}

	private function get_navbar_items($current, $loggedin, $admin = FALSE) {
		$items = array();
		foreach ($this->navbar_items as $key => $value) {
			if (($admin && ($value['for_admin'] === 1 || $value['for_admin'] === 2)) &&
				(($loggedin && ($value['for_loggedin'] === 1 || $value['for_loggedin'] === 2)) ||
				($loggedin === FALSE && ($value['for_loggedin'] === 0 || $value['for_loggedin'] === 2)))) {
				$items[$key] = $this->set_navbar_item($current, $key, $value);
			} elseif (($admin === FALSE && ($value['for_admin'] === 0 || $value['for_admin'] === 2)) &&
				(($loggedin && ($value['for_loggedin'] === 1 || $value['for_loggedin'] === 2)) ||
				($loggedin === FALSE && ($value['for_loggedin'] === 0 || $value['for_loggedin'] === 2)))) {
				$items[$key] = $this->set_navbar_item($current, $key, $value);
			}
		}
		return $items;
	}

	private function set_navbar_item($current, $key, $value) {
		$uri = ($value['for_admin'] === 1) ?
			$this->build_admin_uri($value['param_uri']) :
			$this->build_uri($value['param_uri']);
		$active = ($key === $current) ? TRUE : FALSE;
		$item = array(
			'uri' => $uri,
			'title' => $value['title'],
			'active' => $active,
			'for_loggedin' => $value['for_loggedin']
		);
		return $item;
	}

	/*
	  'PROJECT_LIST' => array(
	  'param_uri' => array('o=PROJECT', 'a=LIST'),
	  'title' => 'Lista projektów',
	  'active' => FALSE,
	  'for_loggedin' => 2, // 0 - No, 1 - Yes, 2 - No & Yes
	  'for_admin' => 1 // 0 - No, 1 - Yes, 2 - No & Yes
	  ),
	  'AUTH_LOGIN' => array(
	  'param_uri' => array('o=AUTH', 'a=LOGIN'),
	  'title' => 'Zaloguj',
	  'active' => FALSE,
	  'for_loggedin' => 0,
	  'for_admin' => 2
	  ),
	  'AUTH_LOGOUT' => array(
	  'param_uri' => array('o=AUTH', 'a=LOGOUT'),
	  'title' => 'Wyloguj',
	  'active' => FALSE,
	  'for_loggedin' => 1,
	  'for_admin' => 2
	  )
	 */

	/**
	 * =====================================================================
	 */

	/**
	 * Set path to user project files
	 * @param string $project_name
	 * @param string $user_email
	 */
	public function set_user_project_path($project_name, $user_email) {
		if (strlen($project_name) > 0 && strlen($user_email)) {
			$hash_name = md5($project_name);
			$mail_slug = $this->Slug->make($user_email, TRUE);
			$format = PROJECTSUSERSPATH . '%s/';
			$args = array($hash_name, $mail_slug);
			$path = vsprintf($format, $args);
			$this->user_project_path = $path;
		} else {
			$this->user_project_path = '';
		}
	}

	/**
	 * Get path to user project files
	 * @return string
	 */
	public function get_user_project_path() {
		return $this->user_project_path;
	}

}
