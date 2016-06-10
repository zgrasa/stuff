<?php
require_once __DIR__ . '/Controller/sessionController.php';

SessionController::initializeSessionManager();

if(SessionController::isLoggedIn()&&isset($_GET['id'])){
    require_once __DIR__ . '/Class/User.php';
    require_once __DIR__ . '/Model/Users.php';
    require_once __DIR__ . '/Model/Blogs.php';
    require_once __DIR__ . '/Class/Post.php';
    require_once __DIR__ . '/Class/Comment.php';
    require_once __DIR__ . '/Model/Comments.php';

    $usermapper = new Users();
    $blogmapper = new Blogs();
    $commentmapper = new Comments();

    $deleteId = $_GET['id'];
    $blogs = $blogmapper->getEntries();
    foreach($blogs as $post){
        if($post->getId()==$deleteId && $post->getUserId()==SessionController::get('id')){
            $blogmapper->deleteEntry($deleteId);
            $blogmapper->save();

            foreach($commentmapper->getComments() as $comment){
                if($comment->getBlogId()==$post->getId()){
                    $commentmapper->deleteComment($comment->getId());
                }
            }
            $commentmapper->save();


            header("Location: /");
        }
    }












}