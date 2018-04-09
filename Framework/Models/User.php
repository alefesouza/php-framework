<?php

namespace Framework\Models;

class User extends JsonCommon
{
    protected $id;
    protected $type;
    protected $login;
    protected $name;
    protected $email;
    protected $image;

    public function __construct($id, $type, $login, $name, $email, $image)
    {
        $this->setId($id);
        $this->setType($type);
        $this->setLogin($login);
        $this->setName($name);
        $this->setEmail($email);
        $this->setImage($image);
    }

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
}
