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

require_once LIBPATH . 'IP_Address.class.php';
require_once LIBPATH . 'JSON_File.class.php';
require_once LIBPATH . 'Session.class.php';
require_once LIBPATH . 'Slug.class.php';
require_once LIBPATH . 'Core.class.php';
require_once LIBPATH . 'Template.class.php';
require_once LIBPATH . 'Project.class.php';

$IP = new \VbertTools\IP_Address();
$Session = new \VbertTools\Session();
$Slug = new \VbertTools\Slug();
$Core = new \VbertTools\Core();
$Tpl = new \VbertTools\Template();
$Project = new \VbertTools\Project();

$object = $Core->get_current_object();
$action = $Core->get_current_action();

// For debug
if (DEBUG_MODE) {
    $vars = array(
        'OBJECT' => $object,
        'ACTION' => $action
    );

    $VBDebug->clear();
    $VBDebug->add('BASEPATH', BASEPATH);
    $VBDebug->add('GET', $Core->get_array('GET'));
    $VBDebug->add('POST', $Core->get_array('POST'));
    $VBDebug->add('SESSION', $_SESSION);
    $VBDebug->add('CUSTOMVARS', $vars);

    $navbar_tpl = 'inc/debug.php';
    $debug_data['debug'] = $VBDebug->get_all();
    $debug = $Tpl->load($navbar_tpl, $debug_data, TRUE);
} else {
    $debug = FALSE;
}

$footer = $Tpl->load('inc/footer.php', array(), TRUE);

$data = array(
    'debug' => $debug,
    'footer' => $footer
);
