<?php

require_once 'index.php';

use Framework\Util\Utils;
use Framework\Repositories\ItemRepository;

$item_db = ItemRepository::getInstance();

$code = $data;

$item = $item_db->getItemByCode($code);

if ($item === false) {
    error_response('invalid_code');
}

$json = json_encode(
    array(
        'id' => (int)$item['id'],
        'code' => $code,
        'name' => $item['name'],
        'host' => Utils::LOCATION
    ),
    JSON_PRETTY_PRINT
);

echo $json;
