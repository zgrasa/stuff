<?php

require_once __DIR__ . '/View/body/head.html';
require_once __DIR__ . '/Class/User.php';
require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/Model/Blogs.php';
require_once __DIR__ . '/Class/Post.php';
require_once __DIR__ . '/Model/Comments.php';
require_once __DIR__ . '/Class/Comment.php';
require_once __DIR__ . '/Controller/menuController.php';
require_once __DIR__ . '/Controller/sessionController.php';

$usermapper = new Users();
$blogmapper = new Blogs();
$commentmapper = new Comments();


SessionController::initializeSessionManager();
?>

<body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> <!-- JQueri-Einbindung -->


<header id="header">

    <h1>Sam's Super Blog</h1>

    <div class="logged">
        <?php

        if (SessionController::isLoggedIn()) {
            echo "<strong>Sie sind als " . $usermapper->getUserById(SessionController::get('id'))->getEmail() . " eingeloggt</strong>";
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
        </ul>
    </nav>
    <div class="clear"></div>
</header>


<?php if (SessionController::isLoggedIn()) {
    echo "<div id='newPost'>";
    echo "<section id=\"newBlog\">
        <header>
            <h2>Neuer Blog erstellen</h2>
        </header> ";

    if (isset($_POST['title']) && isset($_POST['message'])) {
        $title = htmlspecialchars(trim($_POST['title']));
        $message = htmlspecialchars(trim($_POST['message']));
        if ($title != "") {
            if ($message != "") {
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
    echo "</div>";
} ?>


<div id="wrapper">
    <section id="blogEntries">
        <header>
            <h2>Blog</h2>
            <p>Willkommen auf dem Blog von Samuel Zgraggen</p>
        </header>
        <?php
        $posts = $blogmapper->getEntries();
        $allcomments = $commentmapper->getComments();

        $key = 0;
        foreach ($posts as $post) {
            $key++;
            $user = $usermapper->getUserById($post->getUserId());
            echo "<div class='post'>";
            echo "<h3 class='postTitle'>" . $post->getTitle() . "</h3>";
            echo "<div class='postAuthor'>" . $user->getEmail() . " am " . $post->getDatetime()->format('Y-m-d H:i') . "</div>";
            echo "<div class='postContent'>" . $post->getContent() . "</div>";
            if (SessionController::isLoggedIn() && SessionController::get('id') == $post->getUserId()) {
                echo "<form action='delete.php?id=" . $post->getId() . "' method='post'><button class='delbutton' type='submit'>Post löschen</button></form>";
            }

            $comments = [];

            foreach ($allcomments as $comment) {
                if ($comment->getBlogId() == $post->getId()) {
                    array_push($comments, $comment);
                }
            }

            if (count($comments) > 0) {
                echo "<h4>Kommentare</h4>";
            }

            foreach ($comments as $comment) {
                echo "<div class='comment'>";
                echo "<div class='commentAuthor'>" . $usermapper->getUserById($comment->getUserId())->getEmail() . " am " .$comment->getDateTime()->format('Y-m-d H:i')."</div>";
                echo "<div class='commentContent'>".$comment->getComment()."</div>";
                echo "</div>";
            }


            if (SessionController::isLoggedIn()) {
                echo "<form action='addComment.php' method='post'>";
                $postId = $post->getId();
                echo "<input type='text' name='postId' class='hidden' value='" . $postId . "'></input>";
                echo "<textarea id='commentField" . $postId . "' name='comment' rows='5' cols='100' class='hidden'></textarea>";
                echo "<button id='comment" . $postId . "' class='commentButton' type='submit'>Kommentieren</button>";
                echo "</form>";


                echo "
                <script>
                    var field" . $postId . " = $('#commentField" . $postId . "');
                    var button" . $postId . " = $('#comment" . $postId . "');
                    $(button" . $postId . ").click(function(event) {
                        
                        if(field" . $postId . ".css('display')=='none'){
                            event.preventDefault();
                            $(field" . $postId . ").css('display','block');
                        }else if($.trim($(field" . $postId . ").val())==''){
                            event.preventDefault();
                            alert('Bitte geben Sie etwas ein.');
                        }
                    });
                
                </script>
                
                
                
                
                ";


            }
            echo "</div>";

        }
        ?>

    </section>


</div>
<?php include_once __DIR__ . '/View/body/footer.html'; ?>
</body>
</html>