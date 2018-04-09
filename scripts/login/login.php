<?php

require_once 'index.php';

use Framework\Util\Utils;
use Framework\Repositories\UserRepository;
use Framework\Repositories\ItemRepository;

$login = $body->login;
$password = $body->password;

$db = UserRepository::getInstance();

$user = $db->checkLogin($login, $password);

if ($user === false) {
    error_response('invalid_login');
}

$image = $db->getimage($user['api_token']);
$image = Utils::pathCombine(Utils::LOCATION, 'files', 'images', $image);

$db::init($user['id']);

$item_db = ItemRepository::getInstance();

$items = $item_db->getItems();

echo json_encode(array(
    'error' => false,
    'user' => $user,
    'image' => $image,
    'items' => $items
), JSON_PRETTY_PRINT);
