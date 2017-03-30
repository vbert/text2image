<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$content = '<h1>Text2Image</h1>'
		. '<a href="' . $uri_admin . '" title="Panel administracyjny">Panel administracyjny</a>';

//require $Core->get_views_dir() . 'base.php';
$data = array(
	'debug' => $debug,
	'content' => $content
);

$template = 'base.php';

$Tpl->load($template, $data);
