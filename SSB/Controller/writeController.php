<?php
require_once __DIR__.'/../models/post.class.php';
require_once __DIR__.'/../mappers/post_mapper.class.php';
require_once __DIR__.'/../mappers/user_mapper.class.php';

// write_controller
if (isset($_POST['submit'])) {
    if (!isset($_POST['title']) || !isset($_POST['topic']) || !isset($_POST['text']) || user_mapper::getInstance()->getLoggedInUser() == null){ 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }else {
        $post = post_mapper::getInstance()->createPost(
            null,
            user_mapper::getInstance()->getLoggedInUser()->userId,
            $_POST['title'],
            $_POST['topic'],
            date('Y-m-d H:i:s'),
            null,
            UploadImage(),
            $_POST['text']
            );
        //response contains the newly generated postId of the post, so go there
        $response = post_mapper::getInstance()->addPost($post);
        header('Location: ../../httpdocs/post.php?postId='.$response.'&msg=Post%20erfolgreich%20hinzugefügt');
    }
}
if (isset($_POST['update'])) {
    if (!isset($_POST['title']) || !isset($_POST['topic']) || !isset($_POST['text']) || user_mapper::getInstance()->getLoggedInUser() == null || !isset($_POST['postId'])) { 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }else {
        //if user would have changed the hidden field to a postId that is not from him
        if (user_mapper::getInstance()->getLoggedInUser()->userId != post_mapper::getInstance()->getPostbyId($_POST['postId'])->userId && !user_mapper::getInstance()->getLoggedInUser()->is_admin) {
            echo "Das ist nicht dein Post, du bist nicht berechtigt";
        } 
        else {
            $upload_image_result = UploadImage();
            $image_before = post_mapper::getInstance()->getPostbyId($_POST['postId'])->image;
            if ($upload_image_result != $image_before) {
                if (file_exists('../../httpdocs/'.$image_before)) {
                    echo "file exists";
                    unlink('../../httpdocs/'.$image_before);
                }
            }
            $post = post_mapper::getInstance()->createPost(
                $_POST['postId'],
                user_mapper::getInstance()->getLoggedInUser()->userId,
                $_POST['title'],
                $_POST['topic'],
                null,
                date('Y-m-d H:i:s'),
                $upload_image_result,
                $_POST['text']
                );
            //response contains the newly generated postId of the post, so go there
            $response = post_mapper::getInstance()->editPost($post);
            header('Location: ../../httpdocs/post.php?postId='.$response.'&msg=Post%20erfolgreich%20bearbeitet');
        }   
    }
}
if (isset($_POST['delete'])) {
    if (!isset($_POST['postId']) || user_mapper::getInstance()->getLoggedInUser() == null){ 
       echo 'Fehler: Bitte überprüfe deine Eingabe.';
    }else {
        $post = false;
        if (null != post_mapper::getInstance()->getPostById($_POST['postId'])) {
            $post = post_mapper::getInstance()->getPostById($_POST['postId']);
        }
        else {
            echo "Fehler: PostId existiert nicht";
        }
        if ($post->userId == user_mapper::getInstance()->getLoggedInUser()->userId || user_mapper::getInstance()->getLoggedInUser()->is_admin) {
            //"save" image path before logging out
            $image_path = post_mapper::getInstance()->getPostbyId($_POST['postId'])->image;
            //everything is fine to delete the post
            $response = post_mapper::getInstance()->deletePost($post->postId);
            //delete the image
                if (file_exists('../../httpdocs/'.$image_path)) {
                    unlink('../../httpdocs/'.$image_path);
                }
            header('Location: ../../httpdocs/user.php?userId='.$post->userId.'&msg=Post%20erfolgreich%20gelöscht');
        }
        else {
            echo "Fehler: nicht berechtigt";
        }
    }
}
