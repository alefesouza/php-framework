<?php

spl_autoload_register(function ($name) {
    // Windows fix, I was using only Windows at this time.
    $name = str_replace('\\', '/', $name).'.php';

    require $name;
});

use Framework\Repositories\BaseRepository;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

date_default_timezone_set('America/Sao_Paulo');

$db = BaseRepository::getInstance();

$token = str_replace('Basic ', '', $_SERVER['HTTP_AUTHORIZATION']);

if (isset($token)) {
    $user_id = $db->checkToken($token);
} else {
    $user_id = '';
}

BaseRepository::init($user_id);
