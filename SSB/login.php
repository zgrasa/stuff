<?php

require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/Controller/sessionController.php';
SessionController::initializeSessionManager();
$mapper = new Users(); ?>

<body>
<?php


if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $user = $mapper->getUser($email, $password);

    if ($user != null) {

        SessionController::set("LoggedIn", true);
        SessionController::set('id', $user->getID());
        echo SessionController::get('id');
        header('Location: /index.php');
    } else {
        echo 'Benutzername/Passwort falsch';
    }
}
?>
<div class="login">
    <form method="post" action="login.php">
        <div>
            <input class="field" type="text" id="email" name="email" required>
            <label for="email">Username</label>
        </div>
        <div class="inline">
            <input class="field" type="password" id="password" name="password" required>
            <label for="password">Passwort</label>
        </div>
        <div>
            <button type="submit" class="button">
                login
            </button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/View/body/footer.html' ?>
</body>
</html>
