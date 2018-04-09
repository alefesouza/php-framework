<?php

namespace Framework\Models;

class Item extends JsonCommon
{
    protected $id;
    protected $user_id;
    protected $name;
    protected $code;

    public function __construct($id, $user_id, $name, $code)
    {
        $this->setId($id);
        $this->setUser_id($user_id);
        $this->setName($name);
        $this->setCode($code);
    }

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = (int)$user_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }
    
    public function getCode()
    {
        return $this->code;
    }
}
