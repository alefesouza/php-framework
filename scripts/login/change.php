<?php

require_once 'index.php';

use Framework\Repositories\UserRepository;

$db = UserRepository::getInstance();

if (empty($user_id)) {
    error_response('unauthorized', 401);
}

$password = password_hash($body->password, PASSWORD_DEFAULT);
$token = md5(uniqid($password));

$db->updatePassword($user_id, $token, $password);

echo json_encode(
  array(
    'error' => false
  )
);
