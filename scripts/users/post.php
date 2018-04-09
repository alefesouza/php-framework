<?php

require_once admin.php;

use Framework\Util\Utils;
use Framework\Repositories\UserRepository;

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    error_response('unauthorized', 401);
}

$login = $body->login;

$db = UserRepository::getInstance();

if ($db->checkUserExists($login) && $old_login != $login) {
    error_response('user_exists');
}

$upload_file = Utils::saveFile('images', $body->file);

$name = $body->name;
$email = $body->email;

$password = $body->password;

$token = md5(uniqid(password_hash($login.$password, PASSWORD_DEFAULT)));
$password = password_hash($password, PASSWORD_DEFAULT);

$result = $db->addUser($data, $name, $email, $login, $password, $token, $upload_file);

echo json_encode($result);
