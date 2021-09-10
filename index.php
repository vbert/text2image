<?php

/**
 * @package Text2Image
 * @author Wojciech Sobczak, wsobczak@gmail.com
 * @copyright (c) 2017
 */
define('BASEPATH', dirname(__FILE__));
require_once 'config/general.php';

if ($Core->in_objects($object) && $Core->in_actions($action)) {
    $controller_name = $Core->build_controller_name(array($object, $action));
    $uri_admin = $Core->build_admin_uri();
} else {
    header('Location: ' . URI_HOME);
}

$navbar_data = array(
    'items' => $Core->navbar($Core->check_loggedin(), FALSE)
);
$navbar_tpl = 'inc/navbar.php';
$data['navbar'] = $Tpl->load($navbar_tpl, $navbar_data, TRUE);

include $Core->get_controllers_dir() . $controller_name;
