<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$uri_do_login = $Core->build_uri(array('o=' . $object, 'a=DO_LOGIN'));
$form_hash = $Core->generate_hash();

$Session->set('hash', $form_hash);
$Session->set('hash_time', time());

$data = array(
	'uri_do_login' => $uri_do_login,
	'hash' => $form_hash
);

$template = 'login_form.php';

$Tpl->load($template, $data);
