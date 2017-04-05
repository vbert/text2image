<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$uri_admin = URI_ADMIN;
$uri_login = URI_LOGIN;

$post = $Core->get_array('POST');

if (array_key_exists('login', $post) && array_key_exists('password', $post) && array_key_exists('hash', $post)) {
	$login = $post['login'];
	$password = $post['password'];
	$hash = $post['hash'];
	$session_hash = $Session->get('hash');

	$DBUsers = new \VbertTools\JSON_File(DBUSERS);
	$users = $DBUsers->get(DBPATH)[0];

	var_dump($users);

	$content = '';

	$data = array(
		'debug' => $debug,
		'content' => $content
	);

	$template = 'inc/base.php';

	$Tpl->load($template, $data);
} else {
	header('Location: ' . URI_LOGIN);
}
