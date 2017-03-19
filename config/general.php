<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

/**
 * General configuration
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
if (filter_input(INPUT_SERVER, 'HTTP_HOST') === 'localhost') {
	define('LOCAL_SERV', TRUE);
} else {
	define('LOCAL_SERV', FALSE);
}

if (LOCAL_SERV) {
	error_reporting(E_ALL & ~E_DEPRECATED);
	date_default_timezone_set('Europe/Warsaw');
	define('BASEURI', 'http://localhost/text2image/');
	define('DEBUG_MODE', TRUE);
} else {
	error_reporting(0);
	define('BASEURI', 'http://...');
	define('DEBUG_MODE', FALSE);
}

define('APP_NAME', 'Text2Image');
define('DEFAULT_HEAD_TITLE', 'Edytor tekstu na zdjęciu.');

$today = getdate();
define('CURRENT_YEAR', $today['year']);

define('ALERT_SUCCESS', 'alert alert-success');
define('ALERT_INFO', 'alert alert-info');
define('ALERT_WARNING', 'alert alert-warning');
define('ALERT_DANGER', 'alert alert-danger');

define('SIGN_DOT', '.');

define('LIBPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'libraries', '')));
define('PROJECTSPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'projects', '')));

define('URI_HOME', BASEURI);
define('PROJECTS_URI', BASEURI . 'projects/');

define('PROJECT_IMAGES', 'images/');
define('PROJECT_FONTS', 'fonts/');
define('PROJECT_META_FILE', 'meta.json');
define('PROJECT_BACKGROUD_FILE', 'bg.jpg');
define('PROJECT_OUTPUT_FILE', 'out.jpg');

if (DEBUG_MODE) {
	require(LIBPATH . 'VBDebug.class.php');
	$VBDebug = new VBDebug();
} else {
	$VBDebug = NULL;
}

//require LIBPATH . 'Session.class.php';
//require LIBPATH . 'helper_slug.php';
//require LIBPATH . 'helper_tools.php';
//require LIBPATH . 'Action.class.php';
