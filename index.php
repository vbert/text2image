<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('BASEPATH', dirname(__FILE__));
require_once 'config/general.php';
ob_start();

$object = $Core->get_current_object();
$action = $Core->get_current_action();

if ($Core->in_objects($object) && $Core->in_actions($action)) {
	$controller_name = $Core->build_controller_name(array($object, $action));
	$uri_admin = $Core->build_admin_uri();
} else {
	header('Location: ' . URI_HOME);
}



// For debug
$vars = array(
	'OBJECT' => $object,
	'ACTION' => $action,
	'CONTROLLER' => $controller_name
);

// For debug
if (DEBUG_MODE) {
	$VBDebug->clear();
	$VBDebug->add('BASEPATH', BASEPATH);
	$VBDebug->add('GET', $_GET);
	$VBDebug->add('POST', $_POST);
	$VBDebug->add('SESSION', $_SESSION);
	$VBDebug->add('CUSTOMVARS', $vars);

	$debug = $VBDebug->get_all();
} else {
	$debug = FALSE;
}

include $Core->get_controllers_dir() . $controller_name;

ob_end_flush();
