<?php
require_once __DIR__."/../Class/commentClass.php";
/*
//comment_mapper
class comment_mapper
{
    private static $singleton = null;
    public static function getInstance()
    {
        if (self::$singleton === null) {
            self::$singleton = new static();
        }
        return self::$singleton;
    }
    
    //Insert new Comment in the DB
    public function addComment($comment)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('INSERT INTO comments (userId, postId, written_date, commenttext) VALUES (:userId, :postId, :written_date, :commenttext)');
            
            $stmt->bindParam(':userId', $comment->userId, PDO::PARAM_INT);
            $stmt->bindParam(':postId', $comment->postId, PDO::PARAM_INT);
            $stmt->bindParam(':written_date', $comment->written_date, PDO::PARAM_STR);
            $stmt->bindParam(':commenttext', $comment->commenttext);
            $result = $stmt->execute();
            if ($result) {
                return $comment->postId;
            } else {
                return "error while inserting";
            }
        } else {
            return;
        }
    }
   
    //Update comment in the DB
    public function editComment($comment)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('UPDATE comments SET edited_date=:edited_date, commenttext=:commenttext  WHERE commentId=:commentId');
            
            
            
            $stmt->bindParam(':edited_date', $comment->edited_date, PDO::PARAM_STR);
            $stmt->bindParam(':commenttext', $comment->commenttext);
            $stmt->bindParam(':commentId', $comment->commentId, PDO::PARAM_INT);
            $result = $stmt->execute();
            return $comment->commentId;
        } else {
            return false;
        }
    }
    
    //removes comment completly from the DB
    public function deleteComment($id)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('DELETE FROM comments WHERE commentId = :commentId');
            
            $stmt->bindParam(':commentId', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            if ($result) {
                return true;
            } else {
                return "error while inserting";
            }
        } else {
            return;
        }
    }
    //creates a new comment object
    public function createComment($commentId, $userId, $postId, $written_date, $edited_date, $commenttext)
    {
        $comment = new comment();
        $comment->commentId = $commentId;
        $comment->userId = $userId;
        $comment->postId = $postId;
        $comment->written_date = $written_date;
        $comment->edited_date = $edited_date;
        $comment->commenttext = htmlspecialchars($commenttext);
        return $comment;
    }

    */



class Comments
{

    private $file = null;
    
    private $comments = [];

    public function createCommentEntry($blogId, $userId, $comment)
    {
        $newId = $this->getNextId();
        $this->comments[$newId] = new Comment($newId, $blogId, $userId, $comment, new DateTime());
    }

    private function getNextId()
    {
        end($this->comments);

        return key($this->comments) + 1;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getComment($id)
    {
        return $this->comments[$id];
    }

    public function deleteComment($id)
    {
        unset($this->comments[$id]);
    }

    function __construct($file)
    {
        $this->file = $file;

        $filecontent = file_get_contents($this->file);
        preg_match_all('/(?P<id>\d*)|(?P<blogId>\d*)|(?P<userId>\d*)|(?P<comment>.*)|(?P<datetime>.*)eol/Us',
            $filecontent, $comments, PREG_SET_ORDER);

        foreach ($comments as $comment) {
            $this->comments[$comment['id']] = new Comment($comment['id'], $comment['blogId'], $comment['userId'],
                $comment['comment'],
                new DateTime($comment['datetime']));
        }
    }

    function save()
    {
        $data = '';
        foreach ($this->comments as $comment) {
            if ($comment == null) {
                continue;
            }

            $data .= $comment->getId() . '|' . $comment->getBlogId() . '|' . $comment->getUserId() . '|' . $comment->getComment() . '|' . $comment->getDatetime()->format('Y-m-d H:i:s') . "eol\n";
        }

        file_put_contents($this->file, $data);
    }
}