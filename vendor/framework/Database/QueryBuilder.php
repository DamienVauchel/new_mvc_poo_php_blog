<?php
// Fluent

namespace Framework\Database;

use function PHPSTORM_META\elementType;

class QueryBuilder
{
    private $select = [];
    private $where = [];
    private $from = [];
    private $insertionTable;
    private $fieldsToInsert = [];
    private $valuesToInsert = [];

    public function select()
    {
        $this->select = func_get_args();
        return $this;
    }

    public function insertInto($table, array $fields)
    {
        $this->insertionTable = $table;
        $this->fieldsToInsert = $fields;
        return $this;
    }

    public function values(array $values)
    {
        $this->valuesToInsert = $values;
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
        $insertionTable = null;
        $fieldsToInsert = null;
        $valuesToInsert = null;
        $from = null;
        $where = null;

        if (!empty($this->select)) {
            $select = 'SELECT '.implode(', ', $this->select);
        }

        if (($this->insertionTable !== null) && is_string($this->insertionTable)) {
            $insertionTable = 'INSERT INTO '.$this->insertionTable;
        }

        if (!empty($this->fieldsToInsert)) {
            $lastValue = end($this->fieldsToInsert);

            $fieldsToInsert = " (";
            foreach ($this->fieldsToInsert as $field) {
                if ($field != $lastValue) {
                    $fieldsToInsert .= $field.', ';
                } else {
                    $fieldsToInsert .= $field;
                }
            }
            $fieldsToInsert .= ")";
        }

        if (!empty($this->valuesToInsert)) {
            $lastValue = end($this->valuesToInsert);

            $valuesToInsert = ' VALUES (';
            foreach ($this->valuesToInsert as $value) {
                if ($value != $lastValue) {
                    $valuesToInsert .= $value.', ';
                } else {
                    $valuesToInsert .= $value;
                }
            }
            $valuesToInsert .= ')';
        }

        if (!empty($this->from)) {
            $from = ' FROM '.implode(', ', $this->from);
        }

        if (!empty($this->where)) {
            $where = ' WHERE '.implode(' AND ', $this->where);
        }

        return $select.$insertionTable.$fieldsToInsert.$valuesToInsert.$from.$where;
    }
}