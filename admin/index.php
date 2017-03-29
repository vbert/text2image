<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('ADMINBASEPATH', dirname(__FILE__));
define('BASEPATH', realpath(ADMINBASEPATH . '/../'));
require_once BASEPATH . '/config/general.php';
ob_start();

if ($Core->check_perm()) {

	//$up1 = 'adminAdm@Marzec!2017';
	//$up2 = 'editorEdi!Marzec@2017';
	//$hup1 = $Core->hash_user($up1);
	//$hup2 = $Core->hash_user($up2);
	//$server = $Core->get_array('SERVER');
	//$hash_auth = $Core->generate_hash($server['PHP_AUTH_USER'] . $server['PHP_AUTH_PW']);

	var_dump(BASEPATH, ADMINBASEPATH);


	/*
	  define('BASEPATH', dirname(__FILE__));
	  require_once 'config/general.php';
	  ob_start();

	  $object = $Core->get_current_object();
	  $action = $Core->get_current_action();

	  if ($Core->in_objects($object) && $Core->in_actions($action)) {
	  $controller_name = $Core->build_controller_name(array($object, $action));
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
	  }

	  include $Core->get_controllers_dir() . $controller_name;
	 */
} else {
	exit('Nie posiadasz uprawnień do oglądania tej strony.');
}

ob_end_flush();
