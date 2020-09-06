<?php
namespace Speeder\Component\Routing;

use Speeder\Debug\Debugger;
use Speeder\Http\RequestMatcher;
use Speeder\Http\HttpException;



/**
 * Gere les routes du fichier Route.json
 */
class Router
{

     /**
     * contient toutes les routes de l'application|chargements des routes et checking
     */
    protected $routes__container;

    /**
     * lis le fichier route.json dans une chaine et le decode en objet php
     *
     * @param [type] $path(le chemin du fichier)
     */
    public function __construct($path)
    {
        $handle=file_get_contents($path);
        $this->routes_container=json_decode($handle);   
       //Debugger::Dump( $this->routes_container);     
    }
    /**
     * Appel la methode Match de RequestMatcher pour matcher l'url et les routes enregistrer
     *
     * @param string $url
     * @return boolean
     */
    public function Check($url)
    {
         try {
             RequestMatcher::Match($url,$this->routes_container);
         } catch (HttpException $e) {
             echo $e;
         }
    }
}
