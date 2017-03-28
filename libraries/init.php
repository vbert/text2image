<?php

if (!defined('BASEPATH')) {
	exit('Bezpośredni dostęp do skryptu jest niedozwolony!');
}

if (DEBUG_MODE) {
	require LIBPATH . 'VBDebug.class.php';
	$VBDebug = new \VbertTools\VBDebug();
} else {
	$VBDebug = NULL;
}

require LIBPATH . 'IP_Address.class.php';
require LIBPATH . 'Session.class.php';
require LIBPATH . 'Slug.class.php';
require LIBPATH . 'Core.class.php';
require LIBPATH . 'Project.class.php';

$IP = new \VbertTools\IP_Address();
$Session = new \VbertTools\Session();
$Slug = new \VbertTools\Slug();
$Core = new \VbertTools\Core($Slug);
$Project = new \VbertTools\Project();
