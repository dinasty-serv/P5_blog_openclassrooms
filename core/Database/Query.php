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

    private $update;

    private $leftJoin;

    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Set table for sql request
     *
     * @param  string $table
     * @return void
     */
    public function table(string $table)
    {
        $this->table = $table;
    }
   
    /**
     * Select fields sql request
     *
     * @param  string ...$fields
     * @return self
     */
    public function select(string ...$fields): self
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
    public function where(array $condition): self
    {
        $this->where = $condition;

        return $this;
    }
    /**
     * Set leftjoin parameters for sql request
     *
     * @param  array $leftjoin
     * @return void
     */
    public function leftJoin(array $leftjoin)
    {
        $this->leftJoin = $leftjoin;
        return $this;
    }
    /**
     * Set insert parameters for sql request
     *
     * @param  array $insert
     * @return self
     */
    public function insert(array $insert): self
    {
        $this->insert = $insert;
        return $this;
    }
    /**
     * Set update parameters for sql request
     *
     * @param  array   $update
     * @param  integer $id
     * @return self
     */
    public function update(array $update, int $id): self
    {
        $this->update = $update;
        $this->id = $id;
        return $this;
    }
    /**
     * Set action sql request
     *
     * @param  string $action
     * @return self
     */
    public function action(string $action): self
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
    public function orderBy(string $field, string $order): self
    {
        $order = $field . " " . $order;
        $this->order = $order;
        return $this;
    }
    /**
     * Set limit
     *
     * @param  integer|null $limit
     * @return self
     */
    public function limit(?int $limit = null): self
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * Return SQL request
     *
     * @return string
     */
    public function __toString(): string
    {
        //Set SELECT $field
        $parts[] = $this->action;

        if ($this->action === 'SELECT') {
            if ($this->select || $this->leftJoin) {
                $parts[] = $this->_buildSelectLeftJoin();
            } else {
                $parts[] = $this->table . '.*';
            }


            //Set FROM $table
            $parts[] = 'FROM';
            $parts[] = $this->table;

            if ($this->leftJoin) {
                $parts[] = $this->_buildLeftJoin();
            }


            if ($this->where) {
                $parts[] = 'WHERE';
                $parts[] = $this-> _buildWhere();
            }
        } elseif ($this->action === 'DELETE') {
            //Set FROM $table
            $parts[] = 'FROM';
            $parts[] = $this->table;
            $parts[] = 'WHERE ';
            $parts[] = $this-> _buildWhere();
        }


        if ($this->update) {
            $parts[] = $this->table;
            $parts[] = 'SET';
            $parts[] = $this-> _buildUpdate();
            $parts[] = 'WHERE id=';
            $parts[] = $this->id;
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
    private function _buildWhere(): string
    {
        $where = [];

        foreach ($this->where as $k => $v) {
            $where[] = ' ' . $this->table . ".$k = :$k";
        }

        return join(' AND ', $where);
    }
    /**
     * Build SQL request for insert
     *
     * @return void
     */
    private function _buildInsert()
    {
        $insert = "";
        $colone = "";
        $val = "";

        $colone .= " (`" . implode("`, `", array_keys($this->insert)) . "`)";
        $val .= " VALUES ( ";
        foreach ($this->insert as $k => $v) {
            $val .= ":$k ,";
        }
        $val =  substr($val, 0, -1);

        $val .= ") ";

       

        $insert .= $colone . '' . $val;
        return $insert;
    }
    /**
     * Build sql request for update
     *
     * @return void
     */
    private function _buildUpdate()
    {
        foreach ($this->update as $k => $v) {
            $where[] = " $k = :$k";
        }

        return join(' , ', $where);
    }
    /**
     * Build sql request for leftJoin
     *
     * @return void
     */
    private function _buildLeftJoin()
    {
        $leftJoin = [];
        foreach ($this->leftJoin as $k => $v) {
            $leftJoin[] = ' LEFT JOIN ' . $v['table'] . ' ON ' . $v['params'];

            $this->select[] = $v['table'];
        }
       
        return join(' ', $leftJoin);
    }
    /**
     * Build sql request for select leftJoin
     *
     * @return void
     */
    private function _buildSelectLeftJoin()
    {
        $selectLeftJoin = [];
        foreach ($this->leftJoin as $k => $v) {
            $selectLeftJoin[] = $this->table . '.*';

            $selectLeftJoin[] = $v['table'] . '.id as ' . $v['select'];
        }
       
        return join(',', $selectLeftJoin);
    }
}
