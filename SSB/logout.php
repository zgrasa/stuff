<?php

require_once __DIR__ . '/Controller/sessionController.php';
require_once __DIR__ . '/Model/Users.php';
SessionController::initializeSessionManager();

$usermapper = new Users();
?>

<body>
<h1>Logout</h1>

<?php

if(SessionController::isLoggedIn() == true) {
    SessionController::set("isLoggedIn", false);
    SessionController::killSession();
    echo $usermapper->getUserById(SessionController::get('id'))->getEmail().' wurde erfolgreich ausgelogged';
} else {
    echo 'Sie sind gar nicht eingelogged';
}

?>
</body>
</html>

