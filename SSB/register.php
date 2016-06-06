<?php
require_once __DIR__ . '/Model/userMapper.php';
require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Controller/sessionController.php';

$mapper = new userMapper();
?>
<body>
<div id="wrapper">
    <div id="main">

        <article class="post">
            <header>
                <div class="title">
                    <h2>Registrierung</h2>
                    <p>Erstelle hier dein eigenes Konto</p>
                    <?php
                    if(isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["password_repeat"])){
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        $password_repeat = $_POST["password_repeat"];
                        if($password_repeat==$password){
                            if(!$mapper->doesUserExist($email)){
                                $mapper->createUser($email,$password);
                                $mapper->save();
                                session_start();
                                SessionController::set("id",$mapper->getUser($email,$password)->getId()) ;
                                SessionController::set("LoggedIn",true);
                                header('Location: /index.php');
                            }else{
                                echo 'user already exists';
                            }
                        }else{
                            echo 'Passwörter stimmen nicht überein';
                        }

                    }
                    ?>
                </div>
            </header>
            <form method="post" action="register.php">

                <div>
                    <div>
                        <label for="emailInput">E-Mail</label>
                        <input type="text" id="emailInput" name="email" required>
                        <br>
                        <label for="password">Passwort ( min. 6 Zeichen, a-Z 0-9 )</label>
                        <input type="password" id="password" name="password"  required>
                        <br>
                        <label for="password_repeat">Passwort wiederholen</label>
                        <input type="password" id="password_repeat" name="password_repeat" required>
                    </div>
                    <div>
                        <button type="submit">Registrieren</button>
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

<?php require_once __DIR__ . '/View/body/footer.html'?>

</body>
</html>
