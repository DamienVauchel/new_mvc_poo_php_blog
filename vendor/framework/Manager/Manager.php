<?php

namespace Framework\Manager;

use Framework\Database\MySQLDatabase;
use Framework\Database\QueryBuilder;
use Framework\Exception\ManagerException;

class Manager
{
    protected $db;
    protected $qb;

    public function __construct()
    {
        $dbClass = new MySQLDatabase();
        $dbClass->connect();
        $this->db = $dbClass->getDbConnection();
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->qb = new QueryBuilder();
    }

    public function findAll($table)
    {
        if (is_string($table)) {
            $q = $this->qb
                ->select("*")
                ->from($table)
                ->getQuery();

            $stmt = $this->db->query($q);
            return $stmt->fetchAll();
        }
        
        throw new ManagerException("Argument has to be a string");
    }
}