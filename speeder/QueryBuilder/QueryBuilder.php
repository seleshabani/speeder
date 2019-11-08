<?php
namespace Speeder\QueryBuilder;

class QueryBuilder
{
    
    protected $fields=[];

    protected $conditions=[];

    protected $table=[];

    public function Create($name,$params=[])
    {
       return 'CREATE TABLE IF NOT EXISTS '.$name.'('.implode(',',$params) .')';
    }
   
}
