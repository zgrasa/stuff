<?php

require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Controller/sessionController.php';
SessionController::initializeSessionManager();
$mapper = new Users(); ?>

<body>
<div id="wrapper">
    <div id="main">
        <article>
            <header>
                <div class="title">
                    <h2>Login</h2>
                    <p>Bitte hier einloggen</p>

                    <nav class="links">
                        <ul>
                            <li class="home"><a href="index.php">Home</a></li>
                            <li><a href="register.php">Registrieren</a></li>
                        </ul>
                    </nav>
                    <div class="clear"></div>
                </div>
            </header>

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
                    <div class="inline">
                        <label for="email">Username</label>
                    </div>
                    <input class="field" type="text" id="email" name="email" required>
                    <br>
                    <div class="inline">
                        <label for="password">Passwort</label>
                    </div>
                    <input class="field" type="password" id="password" name="password" required>
                    <div>
                        <button class="submitbutton" type="submit" class="button">
                            login
                        </button>
                    </div>
                </form>
            </div>
        </article>
    </div>
</div>
<?php require_once __DIR__ . '/View/body/footer.html' ?>
</body>
</html>
