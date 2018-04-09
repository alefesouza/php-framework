<?php

require_once 'index.php';

use Framework\Repositories\ItemRepository;
use Framework\Repositories\UserRepository;
use Framework\Util\Utils;

if (empty($user_id)) {
    error_response('invalid_token');
}

$name = $body->name;
$email = $body->email;

$user_db = UserRepository::getInstance();
$user = $user_db->getUser($user_id);

$code = time();

$db = ItemRepository::getInstance();

$db->addItem($name, $code);

$items = $db->getItems($user_id);

echo json_encode(array('error' => false, 'items' => $items));
