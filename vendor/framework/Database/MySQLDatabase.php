<?php

namespace Framework\Database;

use Framework\App\Config;

/**
 * Class MySQLDatabase
 * @package Framework\Database
 */
class MySQLDatabase
{
    /**
     * @var
     */
    private $dbHost;
    /**
     * @var
     */
    private $dbName;
    /**
     * @var
     */
    private $dbUser;
    /**
     * @var
     */
    private $dbPw;

    /**
     * @var
     */
    private $connection;

    /**
     * MySQLDatabase constructor.
     */
    public function __construct()
    {
        $params = Config::getInstance()->get('database')['mysql'];
        $this->dbHost = $params['dbHost'];
        $this->dbName = $params['dbName'];
        $this->dbUser = $params['dbUser'];
        $this->dbPw = $params['dbPw'];
    }

    /**
     * @return \PDO
     */
    public function connect()
    {
        try {
            $this->connection = new \PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUser, $this->dbPw);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

        return $this->connection;
    }

    /**
     *
     */
    public function disconnect()
    {
        $this->connection = null;
    }

    /**
     * @return \PDO
     */
    public function getDbConnection()
    {
        if ($this->connection instanceof \PDO) {
            return $this->connection;
        }
    }
}
