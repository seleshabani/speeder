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
     * 
     */
    public static function Init()
    {
        // set_exception_handler(function($code, $message, $fichier, $ligne){
        //     echo"jjj", $code;
        //  });
    }
}


/**
 * affiche le contenu complet d'une variable
 */
 function Dump ($var = null) {
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



