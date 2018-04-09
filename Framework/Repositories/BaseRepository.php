<?php

namespace Framework\Repositories;

use PDO;
use PDOException;

class BaseRepository
{
    protected $db;
    protected static $instances;
    protected static $user_id;

    protected function __construct()
    {
        $db_host = 'mysql';
        $db_name = 'alefesouza_php_framework';
        $db_login = 'root';
        $db_password = '';

        try {
            $this->db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_login, $db_password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // var_dump($e);
        }
    }

    public static function init($user_id)
    {
        try {
            $db = self::getInstance()->db;

            self::$user_id = $user_id;
        } catch (PDOException $e) {
            // var_dump($e);
        }
    }

    public static function getInstance()
    {
        $class = get_called_class();

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class;
        }

        return self::$instances[$class];
    }

    public function checkUserExists($login)
    {
        try {
            $query = $this->db->prepare('SELECT * FROM users WHERE login=:login');
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function checkToken($token)
    {
        $query = $this->db->prepare('SELECT id FROM users WHERE api_token=:token');
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($query->rowCount() > 0) {
            return $row['id'];
        }

        return '';
    }
}
