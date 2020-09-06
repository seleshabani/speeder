<?php

namespace Speeder\Debug;

use Speeder\Exception\Exception;
use Speeder\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * classe Debug
 * @author sele shabani <seleshabani4@gmail.com>
 */
class Debugger
{
    private static $controller;
    private static $response;

    public static function Init($request,$response,$routes)
    {
        self::$controller=new Controller($request,$response,$routes);
        self::$response=$response;
    }
    /**
     * Affiche le contenue d'une variable
     */
    public static function Dump($var)
    {
        ob_start();
        if (isset($var)) {
            var_dump($var);
        }else{
            echo "variable null";
        }
        $content=ob_get_clean();
        
        if(is_object($var)){
            $className=get_class ($var);
        }else{
            $className=gettype($var);
        }

        

        self::$controller->renderByTwig('Debug/debug.html',[
        "value"=>$content,'className'=>$className]);
        self::$response->send();
        die();
    }
}