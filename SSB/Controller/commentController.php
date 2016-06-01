<?php
require_once __DIR__.'/../models/comment.class.php';
require_once __DIR__.'/../mappers/comment_mapper.class.php';
require_once __DIR__.'/../mappers/user_mapper.class.php';
require_once __DIR__.'/../mappers/post_mapper.class.php';

// comment_controller
if (isset($_POST['new'])) {
    if (!isset($_POST['postId']) || !isset($_POST['commenttext']) || user_mapper::getInstance()->getLoggedInUser() == null || post_mapper::getInstance()->getPostById($_POST['postId'])->userId == user_mapper::getInstance()->getLoggedInUser()->userId){ 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }else {
        $comment = comment_mapper::getInstance()->createComment(
            null, 
            user_mapper::getInstance()->getLoggedInUser()->userId,
            $_POST['postId'],
            date('Y-m-d H:i:s'),
            null,
            $_POST['commenttext']
            );
        //response contains the postId of the comment, so go there
        $response = comment_mapper::getInstance()->addComment($comment);
        header('Location: ../../httpdocs/post.php?postId='.$response.'&msg=Kommentar%20hinzugefügt');
    }
}
if (isset($_POST['update'])) {
    if (!isset($_POST['commentId']) || !isset($_POST['commenttext']) || user_mapper::getInstance()->getLoggedInUser() == null){ 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }else {
        $logged_in_user = user_mapper::getInstance()->getLoggedInUser();
        if ($logged_in_user->userId == comment_mapper::getInstance()->getCommentById($_POST['commentId'])->userId || $logged_in_user->is_admin || $logged_in_user->userId ==  post_mapper::getInstance()->getPostbyCommentId($_POST['commentId'])->userId) {
            $comment = comment_mapper::getInstance()->createComment(
                $_POST['commentId'],
                user_mapper::getInstance()->getLoggedInUser()->userId,
                null,
                null,
                date('Y-m-d H:i:s'),
                $_POST['commenttext']
            );
            $response = comment_mapper::getInstance()->editComment($comment);
            //go to the postid provided in POST
            header('Location: ../../httpdocs/post.php?postId='.$_POST['postId'].'&msg=Kommentar%20erfolgreich%20bearbeitet');
        }
        else {
            echo "Das ist nicht dein Kommentar, du bist nicht berechtigt";
        } 
    }
}
if (isset($_POST['delete'])) {
    if (!isset($_POST['commentId']) || user_mapper::getInstance()->getLoggedInUser() == null){ 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }else {
        $comment = false;
        if (null != comment_mapper::getInstance()->getCommentById($_POST['commentId'])) {
            $comment = comment_mapper::getInstance()->getCommentById($_POST['commentId']);
        }
        else {
            echo "Fehler: CommentId existiert nicht";
        }
        $logged_in_user = user_mapper::getInstance()->getLoggedInUser();
        if ($comment->userId == user_mapper::getInstance()->getLoggedInUser()->userId || $logged_in_user->is_admin || $logged_in_user->userId ==  post_mapper::getInstance()->getPostbyCommentId($_POST['commentId'])->userId) {
            //everything is fine to delete the comment
            $response = comment_mapper::getInstance()->deleteComment($comment->commentId);
            header('Location: ../../httpdocs/post.php?postId='.$comment->postId.'&msg=Kommentar%20gelöscht');
        }
        else {
            echo "Fehler: nicht berechtigt";
        }
    }
}