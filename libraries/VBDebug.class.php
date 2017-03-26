<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * VB DEBUG class
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2016
 */
class VBDebug {

	private $messages = [];

	public function __construct() {
		$this->clear();
	}

	public function add($key, $value) {
		$this->messages[$key] = $value;
	}

	public function get($key) {
		if (key_exists($key, $this->messages)) {
			return $this->messages[$key];
		} else {
			return FALSE;
		}
	}

	public function get_all() {
		return $this->messages;
	}

	public function clear() {
		$this->messages = [];
	}

}
