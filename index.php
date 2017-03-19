<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('BASEPATH', dirname(__FILE__));
require_once 'config/general.php';
ob_start();

require LIBPATH . 'IP_Address.class.php';
require LIBPATH . 'Session.class.php';
require LIBPATH . 'Slug.class.php';
require LIBPATH . 'JSON_File.class.php';

$IP = new \VbertTools\IP_Address();
$Session = new \VbertTools\Session();
$Slug = new \VbertTools\Slug();
$JsonF = new \VbertTools\JSON_File();

$txt = 'Gąsienicówka blada i |-+| i włocha&taś|ćżź%32?ń.%678|';
$slug = $Slug->make($txt);

$meta = $JsonF->get_name();

$path = PROJECTSPATH . '/nazwa_as_md5/';
$data = array(
	array(
		'name' => 'Projekt nr 1',
		'background' => array(
			'image' => 'bg01.jpg',
			'color' => 255
		)
	)
);
$jf = $JsonF->set($path, $data);

$vars = array(
	'IP' => $IP->get(),
	'BASEPATH' => BASEPATH,
	'DEBUG_MODE' => DEBUG_MODE,
	'URI_HOME' => URI_HOME,
	'STRING' => $txt,
	'SLUG' => $slug,
	'META' => $meta,
	'META_SIZE' => $jf,
	$_SERVER
);
var_dump($vars);

//$Session = new Session();
//$Action = new Action();
//$controller_basename = (defined('BASENAME')) ? BASENAME : 'index';
//$controller_action = (defined('DEFAULT_ACTION')) ? DEFAULT_ACTION : 'show';
//$controller = $Action->build_file_name(array($controller_basename, $controller_action));
//$message = $Session->get('message');
// For debug
if (DEBUG_MODE) {
	$VBDebug->clear();
	$VBDebug->add('BASEPATH', BASEPATH);
	$VBDebug->add('GET', $_GET);
	$VBDebug->add('POST', $_POST);
	//$VBDebug->add('SESSION', $_SESSION);
}

/*
  require $Action->controllers_dir() . $controller;

  require $Action->views_dir(TRUE) . 'head.php';
  require $Action->views_dir(TRUE) . 'navbar.php';
  require $Action->views_dir() . SRC_FILE;
  require $Action->views_dir(TRUE) . 'footer.php';
 */

ob_end_flush();
