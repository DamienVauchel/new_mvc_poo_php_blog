<?php

namespace Manager;

use Framework\Manager\Manager;

class PostManager extends Manager
{
    public function findOneById($id)
    {
        $q = $this->qb
            ->select("*")
            ->from('posts')
            ->where('id = '.$id)
            ->getQuery();

        $stmt = $this->db->query($q);
        return $stmt->fetch();
    }

    public function findOneBySlug($slug)
    {
        $q = $this->qb
            ->select("*")
            ->from('posts')
            ->where('slug = ?')
            ->getQuery();

        $stmt = $this->db->prepare($q);
        $stmt->execute(array($slug));

        return $stmt->fetch();
    }

    public function add($title, $content, $author, $slug)
    {
        $q = $this->qb
            ->insertInto('posts', array('title', 'content', 'author', 'slug', 'creation_date'))
            ->values(array('?', '?', '?', '?', 'NOW()'))
            ->getQuery();
        
        $stmt = $this->db->prepare($q);
        $stmt->execute(array($title, $content, $author, $slug));

        return $stmt;
    }
}