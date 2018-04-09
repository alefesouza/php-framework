<?php

namespace Framework\Repositories;

use Framework\Util\Utils;
use Framework\Models\Item;
use PDO;
use PDOException;

class ItemRepository extends BaseRepository
{
    public function getItems()
    {
        try {
            $db = self::getInstance();

            $query = $this->db->prepare('SELECT * FROM items WHERE user_id=:user_id');
            $query->bindValue(':user_id', self::$user_id, PDO::PARAM_INT);
            $query->execute();

            $items = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $items[] = new Item(
                    $row['id'],
                    $row['user_id'],
                    $row['name'],
                    $row['code']
                );
            }

            return $items;
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function getItemByCode($code)
    {
        try {
            $query = $this->db->prepare('SELECT * FROM items WHERE code=:code');

            $query->bindValue(':code', $code, PDO::PARAM_STR);

            $query->execute();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                return $row;
            }

            return false;
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function addItem($name, $code)
    {
        try {
            $query = $this->db->prepare('INSERT INTO items (user_id, name, code) VALUES (:user_id, :name, :code)');

            $query->bindValue(':user_id', self::$user_id, PDO::PARAM_INT);
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':code', $code, PDO::PARAM_STR);

            $query->execute();

            return array('error' => false, 'item_id' => $this->db->lastInsertId());
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function updateItem($item_id, $name, $code)
    {
        try {
            $query = $this->db->prepare('UPDATE items SET name=:name, code=:code WHERE id=:item_id');

            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':code', $code, PDO::PARAM_STR);
            $query->bindValue(':item_id', $item_id, PDO::PARAM_INT);

            $query->execute();

            return array('error' => false);
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }

    public function deleteItem($item_id)
    {
        try {
            $query = $this->db->prepare('DELETE FROM items WHERE id=:item_id');
            $query->bindValue(':item_id', $item_id, PDO::PARAM_INT);
            $query->execute();

            return array('error' => false);
        } catch (PDOException $e) {
            return array('error' => true);
        }
    }
}
