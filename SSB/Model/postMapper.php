<?php
require_once __DIR__.'/../Class/postClass.php';



/*
// post_mapper
//contains all DB functions of posts and likes
class post_mapper
{
    private static $singleton = null;
    public static function getInstance()
    {
        if (self::$singleton === null) {
            self::$singleton = new static();
        }
        return self::$singleton;
    }
    public function addPost($post)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('INSERT INTO posts (userId, title, posttext, written_date) VALUES (:userId, :title, :posttext, :written_date)');
            
            $stmt->bindParam(':userId', $post->userId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $post->title);
            $stmt->bindParam(':posttext', $post->text);
            $stmt->bindParam(':written_date', $post->written_date, PDO::PARAM_STR);
            $result = $stmt->execute();
            $postid = $connection->lastInsertId();
            if ($result) {
                return $postid;
            } else {
                return "error while inserting";
            }
        } else {
            return;
        }
    }
    public function editPost($post)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('UPDATE posts SET title=:title, posttext=:posttext, edited_date=:edited_date  WHERE postId = :postId');
            
            
            $stmt->bindParam(':title', $post->title);
            $stmt->bindParam(':posttext', $post->text);
            $stmt->bindParam(':edited_date', $post->edited_date, PDO::PARAM_STR);
            $stmt->bindParam(':postId', $post->postId, PDO::PARAM_INT);
            $result = $stmt->execute();
            $postid = $connection->lastInsertId();
            return $post->postId;
        } else {
            return;
        }
    }
    public function deletePost($id)
    {
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('DELETE FROM posts WHERE postId = :postId');
            
            $stmt->bindParam(':postId', $id, PDO::PARAM_INT);
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
    public function createPost($postId, $userId, $title, $written_date, $text)
    {
        $post = new post();
        $post->postId = $postId;
        $post->userId = $userId;
        $post->title = htmlspecialchars($title);
        $post->written_date = $written_date;
        $post->text = htmlspecialchars($text);
        return $post;
    }
    public function getPostbyId($id){
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('SELECT * FROM posts WHERE postId=:postId;');
            
            $stmt->execute(array(':postId' => $id));
            
            $post = $stmt->fetchAll(PDO::FETCH_CLASS, 'post');
            if (!empty($post)) {
                $post = $post[0];
                return $post;
            } else {
            
            return;}
            
        } else {
            return;
        }
    }
    public function getPostbyCommentId($id){
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('SELECT p.postId, p.userId, p.title, p.posttext, p.written_date, FROM posts AS p JOIN comments AS c ON p.postId = c.postId WHERE c.commentId = :commentId');
            
            $stmt->execute(array(':commentId' => $id));
            
            $post = $stmt->fetchAll(PDO::FETCH_CLASS, 'post');
            if (!empty($post)) {
                $post = $post[0];
                return $post;
            } else {
            
            return;}
            
        } else {
            return;
        }
    }
    
    public function getPostsbyUserId($id){
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('SELECT * FROM posts WHERE userId=:userId;');
            
            $stmt->execute(array(':userId' => $id));
            
            $posts = $stmt->fetchAll(PDO::FETCH_CLASS, 'post');
            if (!empty($posts)) {
                return $posts;
            } else {
            
            return;}
            
        } else {
            return;
        }
    }

    public function getAllPosts(){
        $connection = db::getInstance()->connect();
        if (isset($connection)) {
            $stmt = $connection->prepare('SELECT * FROM posts;');
            
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_CLASS, 'post');
            if (!empty($posts)) {
                return $posts;
            } else {
            
            return;}
            
        } else {
            return;
        }
    }
}
*/
class Blog
{
    private $file = null;
    
    private $entries = [];
    

    public function createEntry($user, $title, $content)
    {
        $newId = $this->getNextId();
        $this->entries[$newId] = new BlogEntry($newId, $user, $title, $content, new DateTime());
    }

    private function getNextId()
    {
        end($this->entries);

        return key($this->entries) + 1;
    }

    public function getEntries($sort=null, $order=null)
    {
        if ($sort!= null && $order != null){
            usort($entries,$sort);
        }
        return $this->entries;
    }

    public function getEntry($id)
    {
        return $this->entries[$id];
    }

    public function deleteEntry($id)
    {
        unset($this->entries[$id]);
    }

    function __construct($file)
    {
        $this->file = $file;

        $filecontent = file_get_contents($this->file);
        preg_match_all('/(?P<id>\d*)|(?P<userid>\d*)|(?P<title>.*)|(?P<content>.*)|(?P<datetime>.*)eol/Us',
            $filecontent, $blogentries, PREG_SET_ORDER);

        foreach ($blogentries as $entry) {
            $this->entries[$entry['id']] = new BlogEntry($entry['id'], $entry['userId'], $entry['title'],
                $entry['content'],
                new DateTime($entry['datetime']));
        }
    }

    function save()
    {
        $data = '';
        foreach ($this->entries as $entry) {
            if ($entry == null) {
                continue;
            }

            $data .= $entry->getId() . '§' . $entry->getUserId() . '§' . $entry->getTitle() . '§' . $entry->getContent() . '§' . $entry->getDatetime()->format('Y-m-d H:i:s') . "eol\n";
        }

        file_put_contents($this->file, $data);
    }
}
