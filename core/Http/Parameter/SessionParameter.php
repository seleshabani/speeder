<?php
namespace Speeder\Http\Parameter;

use Speeder\Http\ParameterBag;

class SessionParameter extends ParameterBag
{
    public function Set(string $key, $var = null)
    {
        $_SESSION[$key] = $var;
        $this->parameters[$key]=$var;
    }

    public function SetAll($var = [])
    {
        for ($i = 0; $i < count($var); $i++) {

            foreach ($var[$i] as $k => $v) {
                $this->Set($k, $v);
            }
        }
    }

    /**
     * recupers une cle de l'array
     * @param  $key
     * @return 
     */
    public function Get($key)
    {
        if(isset($this->parameters[$key])){
            return htmlspecialchars($this->parameters[$key]);
        }else{
            return null;
        }
    }
}
