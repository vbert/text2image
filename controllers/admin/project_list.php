<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$content = '<h1>Text2Image</h1>';

//require $Core->get_views_dir() . 'base.php';
$data = array(
	'debug' => $debug,
	'content' => $content
);

$template = 'inc/base.php';

$Tpl->load($template, $data);
