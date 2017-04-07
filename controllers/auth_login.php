<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$form_hash = $Core->generate_hash();
$Session->set('hash', $form_hash);
$Session->set('hash_time', time());

$uri_do_login = $Core->build_uri(array('o=' . $object, 'a=DO_LOGIN'));
$data = array(
	'uri_do_login' => $uri_do_login,
	'hash' => $form_hash,
	'next' => $Core->input('next')
);

$template = 'login_form.php';
$Tpl->load($template, $data);
