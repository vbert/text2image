<?php

if (!defined('BASEPATH')) {
    exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

$session_alert = $Session->get('alert');
$alert = ($session_alert) ? $Core->alert($session_alert) : '';

$next = $Core->input('next');

$form_hash = $Core->generate_hash();
$Session->set('form_hash', $form_hash);
$Session->set('form_hash_time', time());
$Session->del('alert');

$uri_do_login = $Core->build_uri(array('o=' . $object, 'a=DO_LOGIN'));

$template = 'login_form.php';
$data = array(
    'alert' => $alert,
    'form_action' => $uri_do_login,
    'form_hash' => $form_hash,
    'next' => $next
);

$Tpl->load($template, $data);
