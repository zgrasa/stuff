<?php
require_once __DIR__ . '/../Class/User.php';

class User
{
    private $file = null;
    private $users = [];

    function __construct()
    {
        $this->file = __DIR__ . '\SaveFiles\Users.txt';

        $userStrings = [];

        $filecontent = file_get_contents($this->file);
        preg_match_all("/(?P<id>\d*)§(?P<mail>.*)§(?P<pw>.*)eol/Us",
            $filecontent, $userStrings, PREG_SET_ORDER);

        foreach ($userStrings as $user) {
            $this->users[$user['id']] = new User($user['id'], $user['mail'], $user['pw']);
        }
    }

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

    public function doesUserExist($email)
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() == $email)
                return true;
        }
        return false;
    }
    
    function save()
    {
        $data = '';
        foreach ($this->users as $user) {
            if ($user == null) {
                continue;
            }

            $data .= $user->getId() . '§' . $user->getEmail() . '§' . $user->getPassword() . "eol\n";
        }

        file_put_contents($this->file, $data);
    }
}
