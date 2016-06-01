<?php

require_once __DIR__."/Class/userClass.php";
/*
// Users
class Users
{
    
    
public function addUser($user)
    {
        
        if (isset($connection)) {
            
            
            $stmt->bindParam(':username', $user->username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $user->password, PDO::PARAM_STR);
            $newId = $this->getNextId();
            $this->users[$newId] = new User($newId, $mail, md5($pw));
            if ($result) {
                return 1;
            } else {
                return "error while inserting";
            }
        } else {
            return;
        }
    }
    
    public function deleteUser($id)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
           $stmt = $connection->prepare('DELETE FROM users WHERE userId = :userId');
            
            $stmt->bindParam(':userId', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            return $result;
        } else {
            return false;
        }
    }
    public function editUser($user)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('UPDATE users SET password=:password, name=:name WHERE userId = :userId');
            
            
            $stmt->bindParam(':password', $user->password);
            $stmt->bindParam(':name', $user->name);
            $stmt->bindParam(':userId', $user->userId);
            $result = $stmt->execute();
            return $user->userId;
        } else {
            return;
        }
    }
    public function createUser($userId, $username, $password,  $name)
    {
        $user = new user();
        $user->userId = $userId;
        $user->username = htmlspecialchars($username);
        $user->password = $password;
        $user->name = htmlspecialchars($name);
        return $user;
    }
    
    public function getUserById($id)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('SELECT * FROM users WHERE userId=:userId;');
            
            $stmt->execute(array(':userId' => $id));
            
            $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');
            if (!empty($user)) {
                $user = $user[0];
                return $user;
            } else {
            
            return;}
            
        } else {
            return;
        }
    }
    
    
    public function getUserByUsername($username)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('SELECT * FROM users WHERE username=:username;');
            
            $stmt->execute(array(':username' => $username));
            
            $user = $stmt->fetchAll(PDO::FETCH_CLASS, 'user');
            if (!empty($user)) {
                $user = $user[0];
                return $user;
            } else {
            
            return;}
            
        } else {
            return;
        }
    }
    
    public function getLoggedInUser()
    {
        if(!isset($_SESSION)) 
            { 
                session_start(); 
            } 
        if (isset($_SESSION['username'])) {
            $user = self::getInstance()->getUserByUsername($_SESSION['username']);
            return $user;
        } else {
            return;
        }
    }
}
*/
class Users
{
    private $file = null;
    private $users = [];

    public function createUser($mail, $pw)
    {
        $newId = $this->getNextId();
        $this->users[$newId] = new User($newId, $mail, md5($pw));
    }

    private function getNextId()
    {
        end($this->users);

        return key($this->users) + 1;
    }

    public function getUsers()
    {
        return $this->users;
    }

    function __construct($file)
    {
        $this->file = $file;

        $filecontent = file_get_contents($this->file);
        preg_match_all("/(?P<id>\d*)|(?P<mail>.*)|(?P<pw>.*)eol/Us",
            $filecontent, $users, PREG_SET_ORDER);

        foreach ($users as $user) {
            $this->users[$user['id']] = new User($user['id'], $user['mail'], $user['pw']);
        }
    }

    function save()
    {
        $data = '';
        foreach ($this->users as $user) {
            if ($user == null) {
                continue;
            }

            $data .= $user->getId() . '|' . $user->getEmail() . '|' . $user->getPassword() . "eol\n";
        }

        file_put_contents($this->file, $data);
    }

    public function getUser($email, $password)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() == $email && $user->getPassword() == md5($password))
                return $user;
        }
        return null;
    }

    public function getUserById($userId)
    {
        return $this->users[$userId];
    }
    
    public function controlUser($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() == $email)
                return false;
        }
        return true;   
    }
}