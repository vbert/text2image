<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

//$Server = $Core->get_array('SERVER');
//$next = PROTOCOL . $Server['SERVER_NAME'] . $Server['REQUEST_URI'];
$next = $Core->input('next');
$Core->logout($next);
