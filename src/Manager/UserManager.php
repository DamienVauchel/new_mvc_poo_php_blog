<?php

namespace Manager;

use Framework\Manager\Manager;

class UserManager extends Manager
{
    public function add($username, $email, $password)
    {
        $q = $this->qb
            ->insertInto('users', array('username', 'email', 'password', 'roles'))
            ->values(array('?', '?', '?', '"ROLE_AUTHOR"'))
            ->getQuery();

        $stmt = $this->db->prepare($q);
        $stmt->execute(array($username, $email, $password));

        die(var_dump($stmt));

        return $stmt;
    }
}