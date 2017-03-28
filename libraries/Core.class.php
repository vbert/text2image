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
	protected $objects;

	/**
	 * @var string
	 */
	protected $default_object;

	/**
	 * @var array
	 */
	protected $actions;

	/**
	 * @var string
	 */
	protected $default_action;

	/**
	 * Constructor
	 */
	public function __construct($Slug) {
		$this->Slug = $Slug;
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
		if (count($parameters) > 0) {
			$query_string = implode('&', $parameters);
			return BASEURI . '?' . $quesry_string;
		} else {
			return BASEURI;
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
	public function generate_hash() {
		$unique_id = uniqid(rand(), TRUE);
		return hash('sha512', $unique_id);
	}

	/**
	 * Set objects array
	 * @param array $objects
	 */
	public function set_objects($objects = array()) {
		if (count($objects) > 0) {
			$this->objects = $objects;
		} else {
			$default = array(
				'PROJECT', 'USER_PROJECT'
			);
			$this->objects = $default;
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
			$default = array(
				'LIST', 'DETAIL', 'ADD', 'EDIT'
			);
			$this->actions = $default;
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
	public function get_controllers_dir() {
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
			case 'COOKIE':
				$return = filter_input_array(INPUT_COOKIE);
			case 'SERVER':
				$return = filter_input_array(INPUT_SERVER);
			default:
				$return = FALSE;
				break;
		}
		return $return;
	}

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
