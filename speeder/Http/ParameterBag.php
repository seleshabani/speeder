<?php
namespace Speeder\Http;
/**
 * gere les elements de types cles\valeur
 */
class ParameterBag implements \Countable
{
    
    /**
     * parameters
     */
    protected $parameters;

    public function __construct($paramaters)
    {
        $this->parameters=$paramaters;
    }
    /**
     * recuperes toutes les cles
     */
    public function All()
    {
        return $this->parameters;
    }

    /**
     * recupers une cle de l'array
     * @param  $key
     * @return 
     */
    public function Get($key)
    {
        if(isset($this->parameters[$key])){
            return $this->parameters[$key];
        }else{
            return null;
        }
    }

    /**
     * met a jour une cle
     */
    public function Set(string $key, $var = null)
    {
        $this->parameters[$key]=$var;   
    }

    public function SetAll($var = [])
    {
        for ($i=0; $i < count($var); $i++) { 
            
            foreach ($var[$i] as $k => $v) {
                $this->Set($k,$v);
            }
        }
    }

    /**
     * Returne les nombres des parametres
     *
     * @return int
     */
    public function count()
    {
        return \count($this->parameters);
    }

    public function Exist($key)
    {
        return (isset($this->parameters[$key]) && !empty($this->parameters[$key]));
    }
}
