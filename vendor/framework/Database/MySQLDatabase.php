<?php

namespace Framework\Database;

use Framework\App\Config;

class MySQLDatabase
{
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPw;

    private $connection;

    public function __construct()
    {
        $params = Config::getInstance()->get('database')['mysql'];
        $this->dbHost = $params['dbHost'];
        $this->dbName = $params['dbName'];
        $this->dbUser = $params['dbUser'];
        $this->dbPw = $params['dbPw'];
    }

    public function connect()
    {
        var_dump($this->dbHost, $this->dbName, $this->dbUser, $this->dbPw);
        try {
            $this->connection = new \PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUser, $this->dbPw);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

        return $this->connection;
    }

    public function disconnect()
    {
        $this->connection = null;
    }

    public function getDbConnection()
    {
        if ($this->connection instanceof \PDO) {
            return $this->connection;
        }
    }
}
