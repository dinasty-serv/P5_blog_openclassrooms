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

    private $from;

    private $where;

    private $order;

    private $limit;
    /**
     * Select table sql request
     *
     * @param  string $table
     * @return self
     */
    public function from(string $table):self
    {
        $this->from = $table;
        return $this;
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
        $parts = ['SELECT'];
        if ($this->select) {
            $parts[] = join(', ', $this->select);
        } else {
            $parts[] = '*';
        }
        //Set FROM $table

        $parts[] = 'FROM';
        $parts[] = $this->from;

        if ($this->where) {
            $parts[] = 'WHERE';
            $parts[] = $this-> _buildWhere();
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
}
