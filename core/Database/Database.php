<?php
namespace Speeder\Database;

use Speeder\Kernel\AppKernel;
use function Speeder\Debug\Dump;


class Database
{
    
    public function Query($query)
    {
        $req=AppKernel::GetDb()->query($query);
    }

    public function Prepare ($query,$attribut=[])
    {
        $req = AppKernel::GetDb()->prepare($query);
        if ($r = $req->execute($attribut)) {
            if (strpos($query, 'UPDATE') === 0 ||
                strpos($query, 'INSERT') === 0 ||
                strpos($query, 'DELETE') === 0) {
                return $r;
            }
        }else{
            Dump($req->errorInfo());
        }
    }

    public function Find(Type $var = null)
    {
       
    }

    public function FindBy()
    {
        
    }

}
