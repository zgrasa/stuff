<?php

require_once __DIR__ . '/Controller/sessionController.php';
require_once __DIR__ . '/Model/Users.php';
/**
 * Created by PhpStorm.
 * User: bzgras
 * Date: 08.06.2016
 * Time: 17:40
 */
$usermapper = new Users();
if(!SessionController::isLoggedIn()) {
    SessionController::killSession();
    echo $usermapper->getUserById(SessionController::get('id'))->getEmail().' wurde erfolgreich ausgelogged';
} else {
    echo 'Sie sind gar nicht eingelogged';
}

