<?php
namespace Speeder\QueryBuilder;


class SelectQuery extends QueryBuilder
{
    public function Select()
    {
        $this->fields = func_get_args();
        return $this;
    }

    public function From($table, $alias = null)
    {
        if ($alias != null) {
            $this->table = $table . "as " . $alias;
        } else {
            $this->table = $table;
        }
        return $this;
    }

    public function Where()
    {
        $this->conditions = func_get_args();
        return $this;
    }

    public function __toString()
    {
        if(count($this->conditions)>0){
            return 'SELECT ' . implode(",", $this->fields) . ' FROM ' .
                $this->table . ' WHERE ' . implode(' AND ', $this->conditions);
        }else{
            return 'SELECT ' . implode(",", $this->fields) . ' FROM ' . $this->table;
        }
        

    }
}