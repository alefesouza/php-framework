<?php

spl_autoload_register(function ($name) {
    // Windows fix, I was using only Windows at this time.
    $name = str_replace('\\', '/', $name).'.php';

    require $name;
});

use Framework\Repositories\BaseRepository;

session_start();

if (!isset($_SESSION['type'])) {
    error_response('unauthorized', 401);
}

header('Content-Type: application/json; charset=utf-8');

date_default_timezone_set('America/Sao_Paulo');

$db = BaseRepository::getInstance();
