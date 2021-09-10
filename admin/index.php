<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('ADMINBASEPATH', dirname(__FILE__));
define('BASEPATH', realpath(ADMINBASEPATH . '/../'));
require_once BASEPATH . '/config/general.php';

if ($Core->check_perm()) {
    if ($Core->in_objects($object) && $Core->in_actions($action)) {
        $controller_name = $Core->build_controller_name(array($object, $action));
    } else {
        header('Location: ' . URI_ADMIN);
    }

    $navbar_data = array(
        'items' => $Core->navbar($Core->check_loggedin(), TRUE)
    );
    $navbar_tpl = 'inc/navbar.php';
    $data['navbar'] = $Tpl->load($navbar_tpl, $navbar_data, TRUE);

    include $Core->get_controllers_dir('admin') . $controller_name;
} else {
    $Server = $Core->get_array('SERVER');
    $next = PROTOCOL . $Server['SERVER_NAME'] . $Server['REQUEST_URI'];
    $uri_next = URI_LOGIN . '&next=' . $next;
    header('Location: ' . $uri_next);
}
