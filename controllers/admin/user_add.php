<?php

if (!defined('BASEPATH')) {
    exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}


$_id1 = 1;
$_login1 = 'admin';
$_password1 = 'Adm@Marzec!2017';
$password1 = $Core->hash_password($_login1, $_password1);

$_id2 = 2;
$_login2 = 'editor';
$_password2 = 'Edi!Marzec@2017';
$password2 = $Core->hash_password($_login2, $_password2);

$content = '';




$data = array(
    'debug' => $debug,
    'content' => $content
);

$template = 'inc/base.php';

$Tpl->load($template, $data);

