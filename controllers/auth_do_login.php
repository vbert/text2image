<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$post = $Core->get_array('POST');
$next = $post['next'];

if (array_key_exists('login', $post) && array_key_exists('password', $post) && array_key_exists('form_hash', $post)) {
	$login = $post['login'];
	$password = $post['password'];
	$form_hash = $post['form_hash'];
	$session_form_hash = $Session->get('form_hash');

	if ($form_hash === $session_form_hash) {
		$DBUsers = new \VbertTools\JSON_File(DBUSERS);
		$Users = $DBUsers->get(DBPATH, TRUE)[0];

		if (array_key_exists($login, $Users)) {
			$user = $Users[$login];
			$hash_password = $Core->hash_password($login, $password);

			if ($hash_password === $user['password']) {

				$session_user = array(
					'timestamp' => time(),
					'name' => $login,
					'hash' => $Core->hash_user_to_session($hash_password)
				);

				$Session->set('user', $session_user);
				$Session->set('loggedin', TRUE);
				$Session->del('form_hash');
				$Session->del('form_hash_time');

				if ($next) {
					header('Location: ' . $next);
				} else {
					header('Location: ' . URI_HOME);
				}
			} else {
				$alert = array(
					'text' => 'Nieprawidłowe hasło!',
					'type' => ALERT_DANGER,
					'title' => 'Nieudana próba logowania'
				);
				$Session->set('alert', $alert);
				$Core->show_login_form($next);
			}
		} else {
			$alert = array(
				'text' => 'Nieprawidłowy login!',
				'type' => ALERT_DANGER,
				'title' => 'Nieudana próba logowania'
			);
			$Session->set('alert', $alert);
			$Core->show_login_form($next);
		}
	} else {
		$alert = array(
			'text' => 'Nieprawidłowa suma kontrolna formularza!',
			'type' => ALERT_DANGER,
			'title' => 'Nieudana próba logowania'
		);
		$Session->set('alert', $alert);
		$Core->show_login_form($next);
	}
} else {
	$Core->show_login_form($next);
}

