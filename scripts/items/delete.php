<?php

require_once 'index.php';

use Framework\Util\Utils;
use Framework\Repositories\ItemRepository;

if (empty($user_id)) {
    error_response('invalid_token');
}

$id = $data;

$db = ItemRepository::getInstance();

$db->deleteItem($id);

$items = $db->getItems($user_id);

echo json_encode(array('error' => false, 'items' => $items));
