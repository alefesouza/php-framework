<?php

require_once admin.php;

use Framework\Repositories\UserRepository;

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    error_response('unauthorized', 401);
}

$db = UserRepository::getInstance();

$users = $db->getUsers($data);

$json = json_encode(array(
  'error' => false,
  'users' => $users
));

echo $json;
