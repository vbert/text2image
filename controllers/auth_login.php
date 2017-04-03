<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$data = array();

$template = 'login_form.php';

$Tpl->load($template, $data);
