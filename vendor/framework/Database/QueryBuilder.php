<?php
// Fluent

namespace Framework\Database;

use function PHPSTORM_META\elementType;

/**
 * Class QueryBuilder
 * @package Framework\Database
 */
class QueryBuilder
{
    /**
     * @var array
     */
    private $select = [];
    /**
     * @var array
     */
    private $where = [];
    /**
     * @var array
     */
    private $from = [];
    /**
     * @var
     */
    private $insertionTable;
    /**
     * @var array
     */
    private $fieldsToInsert = [];
    /**
     * @var array
     */
    private $valuesToInsert = [];
    /**
     * @var array
     */
    private $update = [];
    /**
     * @var array
     */
    private $updateSets = [];
    /**
     * @var array
     */
    private $delete = [];
    /**
     * @var array
     */
    private $orderBy = [];
    /**
     * @var array
     */
    private $orderOption = [];
    /**
     * @var array
     */
    private $limit = [];

    /**
     * @return $this
     */
    public function select()
    {
        $this->select = func_get_args();
        return $this;
    }

    /**
     * @param $table
     * @param array $fields
     * @return $this
     */
    public function insertInto($table, array $fields)
    {
        $this->insertionTable = $table;
        $this->fieldsToInsert = $fields;
        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function update($table)
    {
        $this->select = null;
        $this->where = null;
        $this->from = null;
        $this->insertionTable = null;
        $this->fieldsToInsert = null;
        $this->orderBy = null;
        $this->update = $table;

        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function delete($table)
    {
        $this->select = null;
        $this->where = null;
        $this->from = null;
        $this->insertionTable = null;
        $this->fieldsToInsert = null;
        $this->orderBy = null;
        $this->delete = $table;

        return $this;
    }

    /**
     * @param array $sets
     * @return $this
     */
    public function set(array $sets)
    {
        $this->updateSets = $sets;
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function values(array $values)
    {
        $this->valuesToInsert = $values;
        return $this;
    }

    /**
     * @return $this
     */
    public function where()
    {
        foreach (func_get_args() as $arg) {
            $this->where[] = $arg;
        }
        return $this;
    }

    /**
     * @param $table
     * @param null $alias
     * @return $this
     */
    public function from($table, $alias = null)
    {
        if ($alias === null) {
            $this->from[] = $table;
        } else {
            $this->from[] = "$table AS $alias";
        }
        return $this;
    }

    /**
     * @param $order
     * @param string $options
     * @return $this
     */
    public function orderBy($order, $options = 'DESC')
    {
        $this->orderBy = $order;
        $this->orderOption = $options;

        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        $select = null;
        $insertionTable = null;
        $fieldsToInsert = null;
        $valuesToInsert = null;
        $from = null;
        $where = null;
        $update = null;
        $updateSets = null;
        $delete = null;
        $orderBy = null;
        $limit = null;

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

        if (!empty($this->update)) {
            $update = 'UPDATE '.$this->update;
        }

        if (!empty($this->updateSets)) {
            end($this->updateSets);
            $lastValue = key($this->updateSets);

            $updateSets = " SET ";
            foreach ($this->updateSets as $field => $value) {
                if ($field != $lastValue) {
                    $updateSets .= $field.' = '.$value.', ';
                } else {
                    $updateSets .= $field.' = '.$value;
                }
            }
        }

        if (!empty($this->orderBy) && !empty($this->orderOption)) {
            $orderBy = ' ORDER BY '.$this->orderBy.' '.$this->orderOption;
        }

        if (!empty($this->delete)) {
            $delete = "DELETE FROM ".$this->delete;
        }

        if (!empty($this->from)) {
            $from = ' FROM '.implode(', ', $this->from);
        }

        if (!empty($this->where)) {
            $where = ' WHERE '.implode(' AND ', $this->where);
        }

        if (!empty($this->limit)) {
            $limit = ' LIMIT '.$this->limit;
        }

        return $select.$delete.$insertionTable.$fieldsToInsert.$valuesToInsert.$update.$updateSets.$from.$where.$orderBy.$limit;
    }
}