<?php

$method = $_SERVER['REQUEST_METHOD'];

$requestParts = explode('/', $_GET['request']);

$controller = $requestParts[0];
$data = $requestParts[1];

$body = file_get_contents('php://input');

if (isset($body)) {
    $body = json_decode($body);
}

$http_methods = array('GET', 'POST', 'PUT', 'DELETE');
$crud_controllers = array('users', 'items');

if (empty($controller)) {
    require_once 'scripts/index.php';
} // Login
elseif ($controller === 'login' && $method === 'POST') {
    if ($data === 'change') {
        require_once 'scripts/login/change.php';
    } elseif ($data === 'admin') {
        require_once 'scripts/login/login_admin.php';
    } else {
        require_once 'scripts/login/login.php';
    }
} // CRUD actions
elseif (in_array($method, $http_methods) && in_array($controller, $crud_controllers)) {
    $method = strtolower($method);

    require_once "scripts/$controller/$method.php";
} else {
    error_response('not_found', 404);
}

function error_response($description, $code = 500)
{
    http_response_code($code);
    exit(json_encode(array('error' => true, 'description' => $description)));
}
