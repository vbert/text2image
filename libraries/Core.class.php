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
	protected $project_path;

	/**
	 * @var string
	 */
	protected $user_project_path;

	/**
	 * Constructor
	 */
	public function __construct($Slug) {
		$this->Slug = $Slug;
		$this->set_controllers_path();
		$this->set_views_path();
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
	 * Set path to project files
	 * @param string $project_name
	 */
	public function set_project_path($project_name) {
		if (strlen($project_name) > 0) {
			$hash_name = md5($project_name);
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
