<?php

require_once __DIR__ . '/Controller/sessionController.php';
require_once __DIR__ . '/Model/Users.php';
require_once __DIR__ . '/Model/Blogs.php';
require_once __DIR__ . '/Model/Comments.php';
require_once __DIR__ . '/Class/Post.php';
require_once __DIR__ . '/Class/User.php';
require_once __DIR__ . '/Class/Comment.php';

SessionController::initializeSessionManager();

if(SessionController::isLoggedIn()){
    if(isset($_POST['comment']) && trim($_POST['comment'])!="" && isset($_POST['postId'])){
        $commentText  = trim($_POST['comment']);
        $postId = $_POST['postId'];

        $commentModel = new Comments();
        $blogModel = new Blogs();
        $blogs = $blogModel->getEntries();
        foreach($blogs as $blog){
            if($blog->getId()==$postId){
                $commentModel->createCommentEntry($postId,SessionController::get('id'),$commentText);
                $commentModel->save();
                
                header('Location: /');
            }
        }
    }
}