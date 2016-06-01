<?php
require_once __DIR__.'/../models/user.php';
require_once __DIR__.'/../mappers/userMapper.class.php';


/*
class user
{
    public $userId;
    public $username;
    public $password;
    public $is_admin;
    public $joined_date;
    public $profilepic;
    public $name;
    public $summary;
    public $likes_count;
    
    public function logout()
    {
        $_SESSION['username'] = null;
        session_destroy();
        return true;
    }
    public static function login($username, $password)
    {
        $user = user_mapper::getInstance()->getUserByUsername($username);
            if ($user) {
                if (password_verify($password, $user->password)) {
                    if(!isset($_SESSION)) 
                        { 
                            session_start(); 
                        } 
                    $_SESSION['username'] = $user->username;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
*/
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