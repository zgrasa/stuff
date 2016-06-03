<?php

class User
{
    private $id;
    private $email;
    private $password;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    function __construct($id, $mail, $pw)
    {
        $this->id = $id;
        $this->email = $mail;
        $this->password = $pw;
    }

}