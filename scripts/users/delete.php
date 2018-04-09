<?php

require_once admin.php;

use Framework\Repositories\UserRepository;

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    error_response('unauthorized', 401);
}

$id = $data;

$db = UserRepository::getInstance();

echo json_encode($db->deleteUser($id));
