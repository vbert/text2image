<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

require_once 'user.php';

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
	define('BASEURI', $user_config['baseuri']);
	define('DEBUG_MODE', FALSE);
}

define('APP_NAME', $user_config['app_name']);
define('DEFAULT_HEAD_TITLE', $user_config['head_title']);
define('URI_HOME', BASEURI);
define('ADMINBASEURI', BASEURI . 'admin/');

$today = getdate();
define('CURRENT_YEAR', $today['year']);

define('ALERT_SUCCESS', 'alert alert-success');
define('ALERT_INFO', 'alert alert-info');
define('ALERT_WARNING', 'alert alert-warning');
define('ALERT_DANGER', 'alert alert-danger');

define('SIGN_DOT', '.');

define('DBPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'db', '')));
define('LIBPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'libraries', '')));
define('VIEWSPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'views', '')));
define('CONTROLLERSPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'controllers', '')));
define('GLOBALFONTSPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'fonts', '')));
define('PROJECTSPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'projects', '')));
define('PROJECTSUSERSPATH', implode(DIRECTORY_SEPARATOR, array(BASEPATH, 'projects', '%s', 'users', '')));

define('PROJECTS_URI', BASEURI . 'projects/');
define('PROJECT_FONTS', 'fonts/');
define('PROJECT_META_FILE', 'meta.json');
define('PROJECT_BACKGROUD_FILE', 'bg.jpg');
define('PROJECT_EXAMPLE_FILE', 'project.jpg');
define('PROJECT_TEMPLATE_FILE', 'template.jpg');
define('PROJECT_THUMBNAIL_FILE', 'thumbnail.jpg');

define('DB_USERS', DBPATH . 'appusers');
define('PROJECTS_USERS_URI', PROJECTS_URI . '%s/users/');
define('PROJECT_OUTPUT_FILE', 'out.jpg');

require LIBPATH . 'init.php';
