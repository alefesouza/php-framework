<?php

namespace Framework\Repositories;

use Framework\Models\User;
use PDO;
use PDOException;

class UserRepository extends BaseRepository
{
    public function getUsers($type = 'all')
    {
        try {
            if ($type === 'all') {
                $query = $this->db->prepare('SELECT * FROM users');
            } else {
                $query = $this->db->prepare('SELECT * FROM users WHERE type=:type');
                $query->bindValue(':type', $type, PDO::PARAM_STR);
            }

            $query->execute();

            $users = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['id'],
                    $row['type'],
                    $row['login'],
                    $row['name'],
                    $row['email'],
                    $row['image']
                );
            }

            return $users;
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function getUser($id)
    {
        try {
            $query = $this->db->prepare('SELECT * FROM users WHERE id=:id');
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                return new User(
                    (int)$row['id'],
                    $row['type'],
                    $row['login'],
                    $row['name'],
                    $row['email'],
                    $row['image']
                );
            }

            return false;
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function addUser($type, $name, $email, $login, $password, $token, $image)
    {
        try {
            $query = $this->db->prepare('INSERT INTO users (type, name, email, login, password, api_token, image) VALUES (:type, :name, :email, :login, :password, :token, :image)');

            $query->bindValue(':type', $type, PDO::PARAM_INT);
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':phone', $phone, PDO::PARAM_STR);
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);
            $query->bindValue(':token', $token, PDO::PARAM_STR);
            $query->bindValue(':image', $image, PDO::PARAM_STR);

            $query->execute();

            $result = array('error' => false, 'user' => new User(
                $this->db->lastInsertId(),
                $type,
                $login,
                $name,
                $email,
                $image
            ));

            return $result;
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function updateUser($type, $name, $email, $login, $image, $id)
    {
        try {
            $query = $this->db->prepare('UPDATE users SET name=:name, email=:email, login=:login WHERE id=:id');

            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':phone', $phone, PDO::PARAM_INT);
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->bindValue(':image', $image, PDO::PARAM_STR);

            $query->bindValue(':id', $id, PDO::PARAM_INT);

            $query->execute();

            return array('error' => false);
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function updatePassword($id, $token, $password)
    {
        try {
            $query = $this->db->prepare('UPDATE users SET api_token=:token, password=:password WHERE id=:id');

            $query->bindValue(':token', $token, PDO::PARAM_STR);
            $query->bindValue(':password', $password, PDO::PARAM_STR);

            $query->bindValue(':id', $id, PDO::PARAM_INT);

            $query->execute();

            return array('error' => false);
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function checkLogin($login, $password)
    {
        try {
            $query = $this->db->prepare('SELECT id, email, login, name, api_token, password FROM users WHERE login=:login OR email=:login');
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $row['password'])) {
                return array(
                    'api_token' => $row['api_token'],
                    'id' => (int)$row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'login' => $row['login']
                );
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function checkLoginAdmin($login, $password)
    {
        try {
            $query = $this->db->prepare('SELECT id, password, type, name FROM users WHERE login=:login');

            $query->bindValue(':login', $login, PDO::PARAM_STR);

            $query->execute();

            $row = $query->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $row['password'])) {
                return array(
                    'id' => $row['id'],
                    'type' => $row['type'],
                    'name' => $row['name']
                );
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function deleteUser($id)
    {
        try {
            $query = $this->db->prepare('DELETE FROM users WHERE id=:id');
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            return array('error' => false);
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }
}
