<?php
// Fluent

namespace Framework\Database;

use function PHPSTORM_META\elementType;

class QueryBuilder
{
    private $select = [];
    private $where = [];
    private $from = [];

    public function select()
    {
        $this->select = func_get_args();
        return $this;
    }

    public function where()
    {
        foreach (func_get_args() as $arg) {
            $this->where[] = $arg;
        }
        return $this;
    }

    public function from($table, $alias = null)
    {
        if ($alias === null) {
            $this->from[] = $table;
        } else {
            $this->from[] = "$table AS $alias";
        }
        return $this;
    }

    public function getQuery()
    {
        $select = null;
        $from = null;
        $where = null;

        if (!empty($this->select)) {
            $select = 'SELECT '.implode(', ', $this->select);
        }

        if (!empty($this->from)) {
            $from = ' FROM '.implode(', ', $this->from);
        }

        if (!empty($this->where)) {
            $where = ' WHERE '.implode(' AND ', $this->where);
        }

        return $select.$from.$where;
    }
}