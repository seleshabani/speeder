<?php
namespace Speeder\Database;

use Speeder\Builder\QueryBuilder;
use function Speeder\Debug\Dump;


class Manager
{
    protected $db;

    public function __construct()
    {
        $this->db=new Database();
    }

    public function Select($query,$one)
    {
        
    }
    /**
     * Undocumented function
     *
     * @param string $query
     * @param mixed $attributs listes des paarametres peut etre un tableau ou un objet
     * @return boolean
     */
    public function Add($query,$attributs)
    {
        if(is_object($attributs)){

            $params=$attributs->GetProp();

            if (array_key_exists('id',$params)) {
                unset($params['id']);

                foreach ($params as $k => $v) {
                    $j[]=$v;
                }
            }
            
        }else{
            $j= $attributs;
        }

        $return=$this->db->prepare($query,$j);
        
        return $return;

    }

    public function Update($query)
    {
        
    }

    public function Delete($query)
    {

    }
}
