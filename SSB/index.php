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

    <h1>Sam's Super Blog</h1>

    <div class="logged">
        <?php

        if (SessionController::isLoggedIn()) {
            echo "<strong>Sie sind als " . $usermapper->getUserById(SessionController::get('id'))->getEmail() . " eingeloggt<strong>";
        }

        ?>
    </div>


    <nav class="links">
        <ul>
            <?php if (SessionController::isLoggedIn()) {
                echo "<li><a class='logout' href='logout.php'>Logout</a></li>";
            } else {
                echo "<li><a href='login.php'>Login</a></li>";
                echo "<li><a class='menu' href='register.php'>Registrieren</a></li>";
            }
            ?>
            <!--       <li><a href="login.php">Login</a></li>
                   <li class="menu"><a href="register.php">Registrieren</a></li>
                   <li class="logout"><a href="logout.php">Logout</a></li> -->
        </ul>
    </nav>

</header>


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
                    echo "Thema: " . $title . "<br>";
                    echo "Message: " . $message;
                    $blogmapper->createEntry(SessionController::get('id'), $title, $message);
                    $blogmapper->save();
                } else {
                    echo "Es wird eine Nachricht benötigt";
                }
            } else {
                echo "<span class='errormessage'> Der Post benötigt einen Titel!</span>";
            }

        }

        echo "<form id=\"new\" method=\"post\" action=\"#\">
            <div class=\"inline\">
            <label for=\"title\">Thema</label>
            </div>
            <input type=\"text\" name=\"title\">
            <br>
            <div class=\"inline\">
            <label for=\"message\">Content</label>
            </div>
            <textarea type=\"text\" name=\"message\" cols=\"50\" rows=\"8\"></textarea>
            <br>
            <button id=\"postbutton\" type=\"submit\">Post</button>
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
        foreach ($posts as $post) {
            $user = $usermapper->getUserById($post->getUserId());
            echo "<div class='post'>";
            echo "<h3>" . $post->getTitle() ."</h3>";
            echo "<div>". $user->getEmail() . " am ". $post->getDatetime()->format('Y-m-d H:i') ."</div>";
            echo "<div>". $post->getContent() ."</div>";
            if (SessionController::isLoggedIn() && SessionController::get('id') == $post->getUserId()) {
                echo "<form action='delete.php?id=" . $post->getId() . "' method='post'><button class='delbutton' type='submit'>Eintrag löschen</button></form>";
            }
            echo "</div>";





//User: "  " schrieb am "  " Thema: "  " Content: "   "</div>";

        }
        ?>


    </section>


</div>
<?php include_once __DIR__ . '/View/body/footer.html'; ?>
</body>
</html>


