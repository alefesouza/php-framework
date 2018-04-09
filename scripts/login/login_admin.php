<?php

require_once 'index.php';

use Framework\Util\Utils;
use Framework\Repositories\UserRepository;

$db = UserRepository::getInstance();

$login = $body->login;
$password = $body->password;

$user = $db->checkLoginAdmin($login, $password);

if ($user !== false) {
    error_response('invalid_login');
}

if ($user['type'] !== 1) {
    error_response('unauthorized', 401);
}

session_start();

$_SESSION['id'] = $user['id'];
$_SESSION['type'] = $user['type'];
$_SESSION['image'] = $user['image'];
$_SESSION['name'] = $user['name'];

echo json_encode(
    array(
        'error' => false,
        'description' => 'success',
        'name' => $user['name'],
        'image' => $user['image']
    )
);
