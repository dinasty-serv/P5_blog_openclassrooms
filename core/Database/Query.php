<?php
namespace Framework\Database;

/**
 * Class query builder
 *
 * @author Nicolas de Fontaine <nicolas.defontaine@apizee.com>
 */
class Query
{
    private $select;

    private $table;

    private $where;

    private $action;

    private $order;

    private $limit;

    private $insert;

    public function __construct($table)
    {
        $this->table = $table;
    }
   
    /**
     * Select fields sql request
     *
     * @param  string ...$fields
     * @return self
     */
    public function select(string ...$fields):self
    {
        $this->select = $fields;
        return $this;
    }
    /**
     * set conditions
     *
     * @param  array $condition
     * @return self
     */
    public function where(array $condition):self
    {
        $this->where = $condition;

        return $this;
    }

    public function insert(array $insert):self
    {
        $this->insert = $insert;
        return $this;
    }

    public function action(string $action):self
    {
        $this->action = $action;
        return $this;
    }
    /**
     * Set orderBy
     *
     * @param  string $field
     * @param  string $order
     * @return self
     */
    public function orderBy(string $field, string $order):self
    {
        $order = $field." ".$order;
        $this->order = $order;
        return $this;
    }
    /**
     * Set limit
     *
     * @param  integer|null $limit
     * @return self
     */
    public function limit(?int $limit = null):self
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * Return SQL request
     *
     * @return string
     */
    public function __toString():string
    {
        //Set SELECT $field
        $parts[] = $this->action;

        if ($this->action === 'SELECT') {
            if ($this->select) {
                $parts[] = join(', ', $this->select);
            } else {
                $parts[] = '*';
            }

            //Set FROM $table
            $parts[] = 'FROM';
            $parts[] = $this->table;


            if ($this->where) {
                $parts[] = 'WHERE';
                $parts[] = $this-> _buildWhere();
            }
        }

       

        if ($this->insert) {
            $parts[] = 'INTO';
            $parts[] = $this->table;

            $parts[] = $this-> _buildInsert();
        }


        if ($this->order) {
            $parts[] = 'ORDER BY ';
            $parts[] = $this->order;
        }


        if ($this->limit) {
            $parts[] = 'LIMIT';
            $parts[] = $this->limit;
        }

        return join(' ', $parts);
    }
    /**
     * Build where conditions
     *
     * @return string
     */
    private function _buildWhere():string
    {
        $where = [];

        foreach ($this->where as $k => $v) {
            if (is_string($v)) {
                $value = "'".$v."'";
            } else {
                $value = $v;
            }

            $where[] = " $k = $value";
        }

        return join(' AND ', $where);
    }

    private function _buildInsert()
    {
        $insert = "";
        $colone = "";
        $val = "";

        $colone .= " (`".implode("`, `", array_keys($this->insert))."`)";
        $val .= " VALUES ('".implode("', '", $this->insert)."') ";

        $insert .= $colone.''.$val;
        return $insert;
    }
}
