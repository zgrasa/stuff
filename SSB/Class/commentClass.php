<?php

class Comment
{
    private $id;
    private $blogId;
    private $userId;
    private $comment;
    private $datetime;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getBlogId()
    {
        return $this->blogId;
    }

    public function setBlogid($blogId)
    {
        $this->blogid = $blogId;
    }

    public function getUserid()
    {
        return $this->userId;
    }

    public function setUserid($userId)
    {
        $this->userid = $userId;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }
    
    public function __construct($id, $blogId, $userId, $comment, $datetime)
    {
        $this->id = $id;
        $this->blogId = $blogId;
        $this->userId = $userId;
        $this->comment = $comment;
        $this->datetime = $datetime;
    }
}
