<?php

require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Class/User.php';
require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/Model/Blogs.php';
require_once __DIR__ . '/Model/Comments.php';
require_once __DIR__ . '/Controller/menuController.php';
require_once __DIR__ . '/Controller/sessionController.php';

$usermapper = new Users();
SessionController::initializeSessionManager();
?>

<body>

<header id="header">
    <?php
    if(SessionController::isLoggedIn()){
        echo 'loggedIn';
    }
    
    if(SessionController::isLoggedIn()){
        echo 'als '.$usermapper->getUserById(SessionController::get('id'))->getEmail().' eingeloggt';
    } else{
        echo 'Sie sind nicht eingelogged';
    }
    

    ?>
    <nav class="links">
        <ul>
            <li><a href="login.php">Login</a></li>
        </ul>
        <ul>
            <li class="menu">
                <a href="register.php">Registrieren</a>
            </li>
        </ul>
        <ul>
            <li class="logout">
                <button type="button" onclick="" >Logout</button>
            </li>
        </ul>


    </nav>
</header>

<h1>The Ultimate Blog</h1>

<div id="wrapper">

    <div id="main">
    </div>

    <section id="sidebar">

        <section id="intro">
            <header>
                <h2>Blog</h2>
                <p>Willkommen auf dem Blog von Samuel Zgraggen</p>
            </header>
        </section>

        <section id="blog">

        </section>

    </section>

</div>
<?php include_once __DIR__ . '/View/body/footer.html'; ?>

</body>

</html>


