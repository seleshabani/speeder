<?php
namespace Speeder\Database;

class Entity
{
 
    public function GetProp(){

        return get_object_vars($this);
    }

    public function Set($key,$val)
    {
        $this->$key=$val;
    }

    public function Get($key)
    {
        return $this->$key;
    }
    
}
