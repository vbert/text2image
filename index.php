<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('BASEPATH', dirname(__FILE__));
require_once 'config/general.php';

$object = $Core->get_current_object();
$action = $Core->get_current_action();

if ($Core->in_objects($object) && $Core->in_actions($action)) {
	$controller_name = $Core->build_controller_name(array($object, $action));
	if ($object !== 'AUTH' && $action !== 'LOGIN') {
		$Session->del('hash');
		$Session->del('hash_time');
	}
	$uri_admin = $Core->build_admin_uri();
} else {
	header('Location: ' . URI_HOME);
}

// For debug
if (DEBUG_MODE) {
	$vars = array(
		'OBJECT' => $object,
		'ACTION' => $action,
		'CONTROLLER' => $controller_name
	);

	$VBDebug->clear();
	$VBDebug->add('BASEPATH', BASEPATH);
	$VBDebug->add('GET', $Core->get_array('GET'));
	$VBDebug->add('POST', $Core->get_array('POST'));
	$VBDebug->add('SESSION', $_SESSION);
	$VBDebug->add('CUSTOMVARS', $vars);

	$debug = $VBDebug->get_all();
} else {
	$debug = FALSE;
}

include $Core->get_controllers_dir() . $controller_name;
