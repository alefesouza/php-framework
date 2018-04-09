<?php

require_once 'index.php';

use Framework\Repositories\ItemRepository;
use Framework\Repositories\UserRepository;
use Framework\Util\Utils;

if (empty($user_id)) {
    error_response('invalid_token');
}

$item_id = $body->id;
$name = $body->name;

$code = time();

$db = ItemRepository::getInstance();

$db->updateItem($item_id, $name, $code, $email);

$items = $db->getItems();

echo json_encode(array('error' => false, 'code' => $code, 'items' => $items));
