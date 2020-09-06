<?php
namespace Speeder\QueryBuilder;
use Speeder\QueryBuilder\QueryBuilder;


class InsertQuery extends QueryBuilder
{

    public function Into($table)
    {
        $this->table = $table;
        return $this;
    }

    public function Insert()
    {
        $this->fields = func_get_args();
        return $this;
    }

    public function __toString()
    {
        $fiels = '';
        for ($i = 0; $i < count($this->fields); $i++) {
            $fiels .= $this->fields[$i] . '=?,';
        }

        $fiels = preg_replace('#,$#', '', $fiels);

        return "INSERT INTO " . $this->table . " SET " . $fiels;
    }
}