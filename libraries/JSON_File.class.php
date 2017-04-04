<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * JSON_File
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
class JSON_File {

	/**
	 * @var string File name
	 */
	protected $file_name;

	/**
	 * @var string Default file name
	 */
	private $default_file_name = 'meta.json';

	/**
	 * Constructor
	 */
	public function __construct($file_name = '') {
		if (strlen($file_name) > 0) {
			$this->set_file_name($file_name);
		} else {
			$this->set_file_name($this->default_file_name);
		}
	}

	/**
	 * Set file name
	 * @param string $file_name File name
	 */
	public function set_file_name($file_name) {
		if (strlen($file_name) > 0) {
			$this->file_name = $file_name;
		} else {
			$this->file_name = '';
		}
	}

	/**
	 * Get file name
	 * @return string
	 */
	public function get_file_name() {
		return $this->file_name;
	}

	/**
	 * Decode and get data from file
	 * @param string $path Path to json file
	 * @return array
	 */
	public function get($path) {
		$json = $this->read($path);
		$data = json_decode($json);
		return $data;
	}

	/**
	 * Read content file
	 * @param string $path Path to json file
	 * @return string
	 */
	private function read($path) {
		$file = $path . $this->get_file_name();
		if (file_exists($file)) {
			$content = file_get_contents($file);
		} else {
			$content = '[{"error":"Plik nie istnieje!"}]';
		}
		return $content;
	}

	/**
	 * Set and encode data for file
	 * @param string $path Path to json file
	 * @param array $data Data for save
	 * @return integer|boolen
	 */
	public function set($path, $data) {
		$options = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK;
		$json = json_encode($data, $options);
		$result = $this->write($path, $json);
		return $result;
	}

	/**
	 * Write content to file
	 * @param string $path Path to json file
	 * @param string $content Data to save
	 * @return integer|boolen
	 */
	private function write($path, $content) {
		$file = $path . $this->get_file_name();
		if (file_exists($file)) {
			$handle = fopen($file, 'w+');
			$size = fwrite($handle, $content);
			fclose($handle);
			return $size;
		} else {
			return '[{"error":"Plik nie istnieje!"}]';
		}
	}

}
