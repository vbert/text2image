<?php

namespace VbertTools;

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * Project management
 *
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
class Project extends JSON_File {

	/**
	 * @var array Projects data
	 */
	protected $projects = array();

	/**
	 * @var string Current project path
	 */
	protected $project_path;

	/**
	 * @var string Current project name
	 */
	protected $project_name;

	public function __construct() {
		parent::__construct();

		$this->set_projects();
	}

	/**
	 * Set array with projects data
	 * @param string $projects_path
	 */
	public function set_projects($projects_path = PROJECTSPATH) {
		if (strlen($projects_path) > 0) {
			$dirs = scandir($projects_path);
			foreach ($dirs as $dir) {
				if ($dir !== '.' && $dir !== '..') {
					$path = $projects_path . $dir . '/';
					if (is_dir($path)) {
						$data = $this->get($path);
						$key = $data[0]->name;
						$this->projects[$key] = $data[0];
					}
				}
			}
		}
	}

	/**
	 * Get array with projects data
	 * @return array
	 */
	public function get_projects() {
		return $this->projects;
	}

	/**
	 * Set current project name
	 * @param string $project_name
	 */
	public function set_project_name($project_name) {
		if (strlen($project_name) > 0) {
			$this->project_name = $project_name;
		} else {
			$this->project_name = '';
		}
	}

	/**
	 * Get current project name
	 * @return string
	 */
	public function get_project_name() {
		return $this->project_name;
	}

	/**
	 * Set path to project files
	 * @param string $project_name
	 */
	public function set_project_path() {
		if (strlen($this->get_project_name()) > 0) {
			$hash_name = md5($this->get_project_name());
			$format = PROJECTSPATH . '%s/';
			$args = array($hash_name);
			$path = vsprintf($format, $args);
			$this->project_path = $path;
		} else {
			$this->project_path = '';
		}
	}

	/**
	 * Get path to project files
	 * @return string
	 */
	public function get_project_path() {
		return $this->project_path;
	}

}
