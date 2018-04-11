<?php

namespace Manager;

use Framework\Manager\Manager;

/**
 * Class PostManager
 * @package Manager
 */
class PostManager extends Manager
{
    /**
     * @return array
     */
    public function findFourLast()
    {
        $q = $this->qb
            ->select("*")
            ->from('posts')
            ->orderBy('creation_date')
            ->limit(4)
            ->getQuery();

        $stmt = $this->db->query($q);

        return $stmt->fetchAll();
    }

    /**
     * @param $id
     * @return mixed
     */
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

    /**
     * @param $slug
     * @return mixed
     */
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

    /**
     * @param $title
     * @param $content
     * @param $author
     * @param $slug
     * @return bool|\PDOStatement
     */
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

    /**
     * @param $title
     * @param $content
     * @param $slug
     * @return bool|\PDOStatement
     */
    public function update($title, $content, $slug)
    {
        $q = $this->qb
            ->update('posts')
            ->set(array('title' => '?', 'content' => '?', 'slug' => '?', 'last_update_date' => 'NOW()'))
            ->where('slug = "'.$slug.'"')
            ->getQuery();

        $stmt = $this->db->prepare($q);

        $stmt->execute(array($title, $content, $slug));

        return $stmt;
    }

    /**
     * @param $slug
     * @return bool|\PDOStatement
     */
    public function delete($slug)
    {
        $q = $this->qb
            ->delete('posts')
            ->where('slug = "'.$slug.'"')
            ->getQuery();

        $stmt = $this->db->prepare($q);

        $stmt->execute(array($slug));

        return $stmt;
    }
}