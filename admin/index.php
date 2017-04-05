<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('ADMINBASEPATH', dirname(__FILE__));
define('BASEPATH', realpath(ADMINBASEPATH . '/../'));
require_once BASEPATH . '/config/general.php';

if ($Core->check_perm()) {
	$object = $Core->get_current_object();
	$action = $Core->get_current_action();

	if ($Core->in_objects($object) && $Core->in_actions($action)) {
		$controller_name = $Core->build_controller_name(array($object, $action));
	} else {
		header('Location: ' . ADMIN_URI_HOME);
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
		$VBDebug->add('GET', $_GET);
		$VBDebug->add('POST', $_POST);
		$VBDebug->add('SESSION', $_SESSION);
		$VBDebug->add('CUSTOMVARS', $vars);

		$debug = $VBDebug->get_all();
	} else {
		$debug = FALSE;
	}

	include $Core->get_controllers_dir('admin') . $controller_name;

	//$up1 = 'adminAdm@Marzec!2017';
	//$up2 = 'editorEdi!Marzec@2017';
	//$hup1 = $Core->hash_user($up1);
	//$hup2 = $Core->hash_user($up2);
	//$server = $Core->get_array('SERVER');
	//$hash_auth = $Core->generate_hash($server['PHP_AUTH_USER'] . $server['PHP_AUTH_PW']);
} else {
	//exit('Nie posiadasz uprawnień do oglądania tej strony.');
	$uri_login = $Core->build_uri(array('o=AUTH', 'a=LOGIN'));
	header('Location: ' . $uri_login);
}
