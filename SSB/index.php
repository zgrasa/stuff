<?php

require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Class/User.php';
require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/Model/Blogs.php';
require_once __DIR__ . '/Class/Post.php';
require_once __DIR__ . '/Model/Comments.php';
require_once __DIR__ . '/Controller/menuController.php';
require_once __DIR__ . '/Controller/sessionController.php';

$usermapper = new Users();
$blogmapper = new Blogs();
SessionController::initializeSessionManager();
?>

<body>

<header id="header">
    <?php

    if (SessionController::isLoggedIn()) {
        echo "als " . $usermapper->getUserById(SessionController::get('id'))->getEmail() . " eingeloggt";
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
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
</header>

<h1>The Ultimate Blog</h1>

<div id="wrapper">

    <div id="main">
    </div>

    <?php if (SessionController::isLoggedIn()) {
        echo "<section id=\"newBlog\">
        <header>
            <h2>Neuer Blog erstellen</h2>
        </header> ";

        if (isset($_POST['title']) && isset($_POST['message'])) {
            $title = htmlspecialchars(trim($_POST['title']));
            $message = htmlspecialchars(trim($_POST['message']));
            if ($title != "") {
                if ($message != "") {
                    echo "title: " . $title . "<br>";
                    echo "message: " . $message;
                    $blogmapper->createEntry(SessionController::get('id'), $title, $message);
                    $blogmapper->save();
                } else {
                    echo "Es wird eine Nachricht benötigt";
                }
            } else {
                echo "<span class='errormessage'> Der Post benötigt einen Titel!</span>";
            }

        }

        echo "<form method=\"post\" action=\"#\">
            <label for=\"title\">Titel</label>
            <input type=\"text\" name=\"title\">
            <br>
            <label for=\"message\">Text</label>
            <textarea type=\"text\" name=\"message\" cols=\"50\" rows=\"8\"></textarea>
            <br>
            <button type=\"submit\">Post</button>
        </form>
    </section>";
    } ?>


    <section id="blogEntries">
        <header>
            <h2>Blog</h2>
            <p>Willkommen auf dem Blog von Samuel Zgraggen</p>
        </header>
        <?php
        $posts = $blogmapper->getEntries();
        foreach($posts as $post ){
            $user = $usermapper->getUserById($post->getUserId());
            echo "<div class='post'>User:" . $user->getEmail() . "title:" . $post->getTitle() . "content:" . $post->getContent() . "</div>";
            if(SessionController::isLoggedIn() && SessionController::get('id')==$post->getUserId()){
                echo "<form action='delete.php?id=".$post->getId()."' method='post'><button type='submit'>Eintrag löschen</button></form>";
            }
        }
        ?>


    </section>


</div>
<?php include_once __DIR__ . '/View/body/footer.html'; ?>

</body>

</html>


