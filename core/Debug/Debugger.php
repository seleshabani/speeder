<?php

namespace Speeder\Debug;

use Speeder\Exception\Exception;


/**
 * classe Debug
 * @author sele shabani <seleshabani4@gmail.com>
 */
class Debugger
{

    /**
     * Affiche le contenue d'une variable
     */
    public static function Dump($var)
    {
        if (isset($var)) {
            echo '<pre>';
            var_dump($var);
            die();
            echo '</pre>';
        }else{
            echo '<pre>';
            echo "variable null";
            die();
            echo '</pre>';
        }
    }
}