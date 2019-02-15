<?php

require 'composer/vendor/autoload.php';

session_start();

$action = 'login';
$controller = '\ClementPatigny\Controller\\'; // the namespace

if (isset($_GET['action']) && !empty($_GET['action'])) {
    // the format of the GET parameter is controller.action
    $data = explode('.', $_GET['action']);
    $action = $data[1];
    $controller .= ucfirst($data[0]) . 'Controller';
} else {
    $controller .= 'UsersController';
}

if (class_exists('\ClementPatigny\Controller\UsersController')) {
    $controller = new $controller();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        header("HTTP/1.0 404 Not Found");
        exit;
    }
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}
