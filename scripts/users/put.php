<?php

require_once admin.php;

use Framework\Util\Utils;
use Framework\Repositories\UserRepository;

if (!isset($_SESSION['type']) || $_SESSION['type'] != 1) {
    error_response('unauthorized', 401);
}

$old_login = $body->old_login;
$old_image = $body->old_image;
$login = $body->login;

$db = UserRepository::getInstance();

if ($db->checkUserExists($login) && $old_login != $login) {
    error_response('user_exists');
}

$upload_file = Utils::saveFile('images', $body->file);

if (empty($upload_file)) {
    $upload_file = $old_image;
} else {
    Utils::removeFile('images', $old_image);
}

$id = $body->id;

$name = $body->name;
$email = $body->email;

$password = $body->password;

if (isset($password) && $password != '') {
    $token = md5(uniqid(password_hash($login.$password, PASSWORD_DEFAULT)));
    $password = password_hash($password, PASSWORD_DEFAULT);

    $db->updatePassword($id, $token, $password);
}

$result = $db->updateUser($data, $name, $email, $login, $upload_file, $id);

if (!$result->error) {
    echo json_encode(array('error' => false, 'image' => $upload_file));
} else {
    error_response('error_occurred');
}
