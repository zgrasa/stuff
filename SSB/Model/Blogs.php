<?php
require_once __DIR__.'/../Class/Post.php';

class Blogs
{
    private $file = null;
    
    private $entries = [];
    
    function __construct()
    {
        $this->file = __DIR__ . '\SaveFiles\Posts.txt';

        $filecontent = file_get_contents($this->file);
        preg_match_all("/(?P<id>\d*)§(?P<userid>\d*)§(?P<title>.*)§(?P<content>.*)§(?P<datetime>.*)eol/Us",
            $filecontent, $blogentries, PREG_SET_ORDER);

        foreach ($blogentries as $entry) {
            $this->entries[$entry['id']] = new Post($entry['id'], $entry['userid'], $entry['title'],
                $entry['content'],
                new DateTime($entry['datetime']));
        }
    }
    public function createEntry($user, $title, $content)
    {
        $newId = $this->getNextId();
        $this->entries[$newId] = new Post($newId, $user, $title, $content, new DateTime());
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
