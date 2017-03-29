<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Template
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
class Template {

	/**
	 * @var array
	 */
	private $globals = array();

	/**
	 * @var string
	 */
	private $path = '';

	/**
	 * Constructor
	 */
	public function __construct($path = VIEWSPATH) {
		if (strlen($path) > 0) {
			$this->path = $path;
		}
	}

	/**
	 * Set global vars
	 * @param string | array $key
	 * @param mixed $value
	 */
	public function set_globals($key, $value = NULL) {
		if (is_array($key)) {
			foreach ($key as $k => $v) {
				$this->set_globals($k, $v);
			}
		} else {
			$this->globals[$key] = $value;
		}
	}

	/**
	 * Get global vars
	 * @return array
	 */
	public function get_globals() {
		return $this->globals;
	}

	/**
	 * Parse template and return
	 * @param string $tpl_name
	 * @param array $vars
	 * @param boolean $return
	 * @return string | boolean
	 */
	public function load($tpl_name, $vars = array(), $return = FALSE) {
		$tpl = $this->path . $tpl_name;
		if (file_exists($tpl)) {
			foreach ($vars as $key => $value) {
				$$key = $value;
			}
			unset($vars);

			foreach ($this->globals as $key => $value) {
				$$key = $value;
			}

			ob_start();
			require_once $tpl;
			$template = ob_get_contents();
			ob_end_clean();

			if ($return === FALSE) {
				echo $template;
			} else {
				return $template;
			}
		} else {
			return FALSE;
		}
	}

}
