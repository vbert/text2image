<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('BASEPATH', dirname(__FILE__));
require_once 'config/general.php';
ob_start();

/**
 * For example
 */
/*
  $txt = 'Gąsienicówka blada !wsobczak@gmail.com! i |-+| i włocha&taś|ćżź%32?ń.%678|';
  $slug = $Slug->make($txt);

  $project_name = 'Kubek z misiem';
  $tmail = 'wsobczak@gmail.com';

  $data = array(
  array(
  'name' => $project_name,
  'background' => array(
  'image' => 'bg01.jpg',
  'color' => 255
  )
  )
  );
 */


// For debug
$vars = array(
	'IP' => $IP->get(),
	'BASEPATH' => BASEPATH,
	'DEBUG_MODE' => DEBUG_MODE,
	'URI_HOME' => URI_HOME,
	'PROJECTS' => $Project->get_projects(),
	'CONTROLLERS' => $Core->get_controllers_dir(),
	'VIEWS' => $Core->get_views_dir()
);

// For debug
if (DEBUG_MODE) {
	$VBDebug->clear();
	$VBDebug->add('BASEPATH', BASEPATH);
	$VBDebug->add('GET', $_GET);
	$VBDebug->add('POST', $_POST);
	$VBDebug->add('SESSION', $_SESSION);
	$VBDebug->add('CUSTOMVARS', $vars);
}

require $Core->get_views_dir() . 'base.php';

ob_end_flush();
