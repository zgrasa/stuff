<?php
require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Controller/sessionController.php';
SessionController::initializeSessionManager();

$mapper = new Users();
?>
<body>
<div id="wrapper">
    <div id="main">
        <article>
            <header>
                <div class="title">
                    <h2>Registrierung</h2>
                    <p>Erstelle hier dein eigenes Konto</p>

                    <nav class="links">
                        <ul>
                            <li class="home"><a href="index.php">Home</a></li>
                            <li><a href="login.php">Login</a></li>
                        </ul>
                    </nav>

                    <div class="clear"></div>

                    <?php
                    if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_repeat"])) {
                        $email = htmlspecialchars(trim($_POST["email"]));
                        $password = trim($_POST["password"]);
                        $password_repeat = trim($_POST["password_repeat"]);
                        if ($password_repeat == $password) {
                            if (!$mapper->doesUserExist($email)) {
                                $mapper->createUser($email, $password);
                                $mapper->save();
                                session_start();
                                SessionController::set("id", $mapper->getUser($email, $password)->getId());
                                SessionController::set("LoggedIn", true);
                                header('Location: /index.php');
                            } else {
                                echo 'Diese email wird bereits benutzt';
                            }
                        } else {
                            echo 'Passwörter stimmen nicht überein';
                        }

                    }
                    ?>
                </div>
            </header>
            <form method="post" action="register.php">

                <div>
                    <div>
                        <div class="inline">
                            <label for="emailInput">E-Mail</label>
                        </div>
                        <input type="text" id="emailInput" name="email" required>
                        <br>
                        <div class="inline">
                            <label for="password">Passwort</label>
                        </div>
                        <input type="password" id="password" name="password" required>
                        <br>
                        <div class="inline">
                            <label for="password_repeat">Passwort wiederholen</label>
                        </div>
                        <input type="password" id="password_repeat" name="password_repeat" required>
                    </div>
                    <div>
                        <button class="submitbutton" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </article>
    </div>
</div>

<script>
    $(document).ready(function () {
        RegisterValidate();
    });
</script>

<?php require_once __DIR__ . '/View/body/footer.html' ?>

</body>
</html>
