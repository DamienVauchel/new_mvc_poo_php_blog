<?php

namespace Manager;

use Framework\Manager\Manager;

/**
 * Class CommentManager
 * @package Manager
 */
class CommentManager extends Manager
{
    /**
     * @param $postId
     * @return array
     */
    public function findAllByPost($postId)
    {
        $q = $this->qb
            ->select("*")
            ->from('comments')
            ->where('post_id = ?')
            ->orderBy('creation_date')
            ->getQuery();

        $stmt = $this->db->prepare($q);
        $stmt->execute(array($postId));

        return $stmt->fetchAll();
    }

    public function add($comment, $author, $post_id)
    {
        $q = $this->qb
            ->insertInto('comments', array('comment', 'author', 'creation_date', 'post_id'))
            ->values(array('? ', '? ', 'NOW()', '?'))
            ->getQuery();

        $stmt = $this->db->prepare($q);

        $stmt->execute(array($comment, $author, $post_id));

        return $stmt;
    }
}