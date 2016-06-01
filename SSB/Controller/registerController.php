<?php
require_once __DIR__.'/../models/user.class.php';
require_once __DIR__.'/../mappers/user_mapper.class.php';

// login_controller
if (isset($_POST['create'])) {
    if ((!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password_repeat']) || !isset($_POST['name']) || !isset($_POST['summary']) ) ||  $_POST['password'] != $_POST['password_repeat'] || !preg_match('/^[A-Za-z0-9_\-\.@]{3,}$/', $_POST['username']) || !preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])\S{6,}$/', $_POST['password']) || user_mapper::getInstance()->getUserByUsername($_POST['username'])) {
        header("Location: ../../httpdocs/register.php?msg=Eingaben%20ungültig");
    }
    else {
         $user = user_mapper::getInstance()->createUser(
            null,
            $_POST['username'],
            password_hash($_POST['password'], PASSWORD_DEFAULT),
            date('Y-m-d H:i:s'),
            UploadImage(),
            $_POST['name'],
            $_POST['summary']
            );
        user_mapper::getInstance()->addUser($user);
        $loginresult = user::login($_POST['username'], $_POST['password']);
        header('Location: ../../httpdocs/user.php?username='.$_POST['username'].'&msg=Willkommen%20auf%20deinem%20Blog!');
        
    }
}
if (isset($_POST['update'])) {
    if (!isset($_POST['name']) || !isset($_POST['summary'])) {
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }
    
    else {
        $logged_in_user = user_mapper::getInstance()->getLoggedInUser();
        if (isset($_POST['password']) && isset($_POST['password_repeat'])) {
            if ($_POST['password'] != $_POST['password_repeat']) {
                echo "Passwörter stimmen nicht überein";
            }
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            $passwort = null;
        }
        $upload_image_result = UploadImage();
        $user = user_mapper::getInstance()->createUser(
            $logged_in_user->userId,
            $logged_in_user->username,
            $password,
            null,
            $upload_image_result,
            $_POST['name'],
            $_POST['summary']
            );
        user_mapper::getInstance()->editUser($user);
        header('Location: ../../httpdocs/user.php?username='.$logged_in_user->username.'&msg=Profil%20erfolgreich%20angepasst');
    }
}
if (isset($_POST['delete'])) {
    if (!isset($_POST['userId']) || user_mapper::getInstance()->getLoggedInUser() == null){ 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    } else {
        if (user_mapper::getInstance()->getLoggedInUser()->userId == $_POST['userId'] || user_mapper::getInstance()->getLoggedInUser()->is_admin) {
            
            //"save" profile pic path before logging out
            $image_path = user_mapper::getInstance()->getLoggedInUser()->profilepic;
            user_mapper::getInstance()->getLoggedInUser()->logout();
            $result = user_mapper::getInstance()->deleteUser($_POST['userId']);
            if ($result) {
                $msg = "Benutzerkonto erfolgreich gelöscht";
            } else {
                $msg = "Fehler beim Löschen des Kontos";
            }
           header('Location: ../../httpdocs/index.php?msg='.$msg); 
        }
        else {
            echo "Fehler: Nicht berechtigt";
        }
    }
}
if (isset($_POST['userexist'])) {
    if ($_POST['userexist'] == 'check') {
            if (!isset($_POST['username'])) { 
               echo '{"userexist" : "check", "status" : "error" }';
            } else {
                $user = user_mapper::getInstance()->getUserByUsername($_POST['username']);
                if ($user) {
                    echo '{"userexist" : "check", "status" : "1" }';
                } else {
                    echo '{"userexist" : "check", "status" : "0" }';
                }
            }
        } 
} 