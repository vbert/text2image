<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$uri_admin = $Core->build_admin_uri();
$uri_login = $Core->build_uri(array('o=AUTH', 'a=LOGIN'));


//require $Core->get_views_dir() . 'base.php';
$data = array(
	'debug' => $debug,
	'content' => $content = ''
);

$template = 'inc/base.php';

$Tpl->load($template, $data);
