<?php

namespace Manager;

use Framework\Exception\ManagerException;
use Framework\Manager\Manager;

class PostManager extends Manager
{
    public function findOneById($id)
    {
        $q = $this->qb
            ->select("*")
            ->from('posts')
            ->where('id ='.$id)
            ->getQuery();

        $stmt = $this->db->query($q);
        return $stmt->fetch();
    }
}