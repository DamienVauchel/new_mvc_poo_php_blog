<?php

namespace Manager;

use Framework\Manager\Manager;

/**
 * Class UserManager
 * @package Manager
 */
class UserManager extends Manager
{
    /**
     * @param $username
     * @param $email
     * @param $password
     * @return bool|\PDOStatement
     */
    public function add($username, $email, $password)
    {
        $q = $this->qb
            ->insertInto('users', array('username', 'email', 'password', 'roles'))
            ->values(array('?', '?', '?', '"ROLE_AUTHOR"'))
            ->getQuery();

        $stmt = $this->db->prepare($q);
        $stmt->execute(array($username, $email, $password));

        return $stmt;
    }

    /**
     * @param $username
     * @return mixed
     */
    public function findOneByUsername($username)
    {
        $q = $this->qb
            ->select("*")
            ->from('users')
            ->where('username = '.$username)
            ->getQuery();

        $stmt = $this->db->query($q);
        return $stmt->fetch();
    }
}