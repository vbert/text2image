<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Action class
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2016
 */
class Action {

	private $viewsDir = 'views/';
	private $controllersDir = 'controllers/';
	private $objects = [
		'PAGE', 'FORM'
	];
	private $actions = [
		'SHOW', 'SEND'
	];
	private $lower = 'ęóąśłżźćńĘÓĄŚŁŻŹĆŃ';
	private $upper = 'ĘÓĄŚŁŻŹĆŃĘÓĄŚŁŻŹĆŃ';

	public function __construct() {
		$this->objects2const();
		$this->actions2const();
		$this->set_paths();
	}

	private function objects2const() {
		foreach ($this->objects as $object) {
			define('OBJ_' . $object, $object);
		}
	}

	private function actions2const() {
		foreach ($this->actions as $action) {
			define('AC_' . $action, $action);
		}
	}

	private function set_paths() {
		$this->viewsDir = defined('VIEWPATH') ? VIEWPATH : '';
		$this->controllersDir = defined('CONTROLLERPATH') ? CONTROLLERPATH : '';
	}

	private function in_objects($object) {
		return in_array($object, $this->objects, TRUE);
	}

	private function in_actions($action) {
		return in_array($action, $this->actions, TRUE);
	}

	/**
	 * Generator hash-a
	 */
	public function get_hash() {
		$data = uniqid(rand(), TRUE);
		return hash('sha512', $data);
	}

	/**
	 * Budowanie adresu
	 *
	 * @param array $parameters
	 */
	public function build_uri($parameters = []) {
		$base_uri = BASEURI;
		$query_string = '';
		$num = count($parameters);

		if ($num > 0) {
			$query_string .= implode('&', $parameters);
			return $base_uri . '?' . $query_string;
		} else {
			return $base_uri;
		}
	}

	public function build_file_name($components = []) {
		$num = count($components);
		$file_name = '';

		if ($num > 0) {
			$file_name = implode('_', array_map('strtolower', $components));
			return $file_name . '.php';
		} else {
			return strtolower(DEFAULT_OBJECT) . '_' . strtolower(DEFAULT_ACTION) . '.php';
		}
	}

	/**
	 * Odbieranie danych od klienta
	 */
	public function input($key, $default = NULL) {
		$options = array(
			'flags' => FILTER_NULL_ON_FAILURE
		);
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
	 * Pobieranie danych z cookie lub server
	 * INPUT_COOKIE, INPUT_SERVER
	 */
	public function get_var($key, $type = 'SERVER', $default = NULL) {
		$options = array(
			'flags' => FILTER_NULL_ON_FAILURE
		);
		$return = FALSE;

		if (!is_null($default)) {
			$option = array(
				'default' => $default
			);
			$options['options'] = $option;
			$return = $default;
		}

		if ($type === 'SERVER') {
			$variable = filter_input(INPUT_SERVER, $key, FILTER_DEFAULT, $options);
		} elseif ($type === 'COOKIE') {
			$variable = filter_input(INPUT_COOKIE, $key, FILTER_DEFAULT, $options);
		} else {
			$variable = $return;
		}

		return $variable;
	}

	/**
	 * Pobieranie całych tablic systemowych
	 * INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER
	 */
	public function get_array($type = 'GET') {
		$options = array(
			'flags' => FILTER_NULL_ON_FAILURE
		);
		$return = FALSE;

		$default = NULL;
		if (!is_null($default)) {
			$option = array(
				'default' => $default
			);
			$options['options'] = $option;
			$return = $default;
		}

		if ($type === 'GET') {
			$return = filter_input_array(INPUT_GET);
		} elseif ($type === 'POST') {
			$return = filter_input_array(INPUT_POST);
		} elseif ($type === 'COOKIE') {
			$return = filter_input_array(INPUT_COOKIE);
		} elseif ($type === 'SERVER') {
			$return = filter_input_array(INPUT_SERVER);
		} else {
			$return = FALSE;
		}

		return $return;
	}

	/**
	 * Bezpieczne dane
	 */
	public function sanitize_data($key, $default = NULL) {
		$data = $this->input($key, $default);
		return htmlspecialchars(stripcslashes(trim($data)));
	}

	/**
	 * Aktualny obiekt działania
	 */
	public function get_object($default = DEFAULT_OBJECT) { //
		$ret = $this->input('o', $default);
		if ($this->in_objects($ret)) {
			return $ret;
		}
		return FALSE;
	}

	/**
	 * Akcja do wykonania
	 */
	public function get_action($default = DEFAULT_ACTION) { //
		$ret = $this->input('a', $default);
		if ($this->in_actions($ret)) {
			return $ret;
		}
		return FALSE;
	}

	/**
	 * Ścieżka do kontrolerów
	 */
	public function set_controllers_dir($dir) {
		$this->controllersDir = $dir;
		return $dir;
	}

	public function controllers_dir($core = false) {
		if ($core and defined('COREINCPATH')) {
			return $this->controllersDir . COREINCPATH;
		} else {
			return $this->controllersDir;
		}
	}

	/**
	 * Ścieżka do widoków
	 */
	public function set_views_dir($dir) {
		$this->viewsDir = $dir;
		return $dir;
	}

	public function views_dir($core = false) {
		if ($core and defined('COREINCPATH')) {
			return $this->viewsDir . COREINCPATH;
		} else {
			return $this->viewsDir;
		}
	}

	/**
	 * Limiting the length of the text.
	 * @param string $str source string
	 * @param integer $len maximum number of characters in the text
	 * @param string $end sufix returned text
	 * @return string
	 */
	public function strlimit($str, $len = 10, $end = '...') {
		$encoding = 'UTF-8';
		if (mb_strlen($str, $encoding) <= (int) $len) {
			return $str;
		} else {
			return mb_substr($str, 0, $len, 'UTF-8') . ' ' . $end;
		}
	}

	public function str2upper($str) {
		return (strtoupper(strtr($str, $this->lower, $this->upper)));
	}

	public function str2lower($str) {
		return (strtolower(strtr($str, $this->upper, $this->lower)));
	}

}
