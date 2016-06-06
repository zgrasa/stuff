<?php
require_once __DIR__ . '/../Class/Comment.php';

class Comments
{
    private $file = null;
    private $users = [];
    
    function __construct()
    {
        $this->file = __DIR__ . '\SaveFiles\Comments.txt';
        $comments = [];
        $filecontent = file_get_contents($this->file);
        preg_match_all('/(?P<id>\d*)§(?P<blogId>\d*)§(?P<userId>\d*)§(?P<comment>.*)§(?P<datetime>.*)eol/Us',
            $filecontent, $comments, PREG_SET_ORDER);
        foreach ($comments as $comment) {
            $this->comments[$comment['id']] = new Comment($comment['id'], $comment['blogId'], $comment['userId'],
                $comment['comment'],
                new DateTime($comment['datetime']));
        }
    }
    
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
    
    public function createComment($blogId, $userId, $comment)
    {
        $newId = $this->getNextId();
        $this->users[$newId] = new User($newId, $mail, md5($pw));
    }
    private function getNextId()
    {
        end($this->users);
        return key($this->users) + 1;
    }
    public function getUsers()
    {
        return $this->users;
    }
    function save()
    {
        $data = '';
        foreach ($this->comments as $comment) {
            if ($comment == null) {
                continue;
            }

            $data .= $comment->getId() . '§' . $comment->getBlogId() . '§' . $comment->getUserId() . '§' . $comment->getComment() . '§' . $comment->getDatetime()->format('Y-m-d H:i:s') . "eol\n";
        }

        file_put_contents($this->file, $data);
    }
}
