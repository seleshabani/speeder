<?php
namespace Speeder\Http;

use Speeder\Debug\Debugger;
use Speeder\Component\Routing\Route;
use Speeder\Http\HttpException;
use function Speeder\Debug\Dump;
use Speeder\Controller\Controller;


/**
 * verifie si une url match avec les routes enregistre dans le fichier Route.json
 */
class RequestMatcher
{
    /**
     *listes des routes lies au projets 
     */
    protected $routes=[];


    /**
     * parcours toutes les routes du fichier route.json si tout est ok enregistre une nouvelle route
     *
     * @param string $url
     * @param array $routes
     * @return object
     */
    public static function Match($url,$routes)
    {
        
         $flag=false;
         $request = new Request();//A remplacer | faire en sorte qu'il soit passé en argument depuis App\App

        // Dump('ici');
        
        //key represente la regex
         foreach ($routes as $key=>$value) {
           // Dump(preg_match($key,$url));
            
           if(preg_match($key,$url)){
            
                if(property_exists($value,"params")){

                    $infos=explode($value->ls,$url);
                    $params=[];
                    foreach ($value->params as $k => $v) {
                        array_push($params,[$k => $infos[$v]]);
                    }
                    
                    $request->querys->SetAll($params);
                }
               
                //coupe la chaine recuperer du fichier route.json
                $controller_infos=explode('::',$value->controller);
                $action=$controller_infos[1];

                

                if(class_exists($controller_infos[0])){
                    $controller = new $controller_infos[0]($request);
                    if(is_callable([$controller,$action])){
                         $controller->$action();
                          $flag = true; 
                    }
                   
                }
           }

         }

        if($flag==false){
            $c=new Controller($request);
             $c->To404();     
        }
    }
    
}
