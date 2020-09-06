<?php
namespace Speeder\Http\Parameter;

use Speeder\Http\ParameterBag;

class FileParameter extends ParameterBag
{
    public function Set(string $key, $var = null)
    {
        $_FILES[$key] = $var;
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
    public function Exist($key)
    {
        if(isset($_FILES[$key])){
            return true;
        }else{
            return false;
        }
    }
}