<?php

namespace App;

use Speeder\Http\Request;
use Speeder\Debug\Debugger;
use Speeder\Kernel\AppKernel;
use Speeder\Component\Routing\Router;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Speeder\Controller\Controller;

class App extends AppKernel
{
    /**
     * lance l'application avec les composantes de la première version sans les élèments de symfony
     */
    public function Handle(Request $request)
    {
       $path=$this->GetProjectDir().$this->Ds()."config/Route.json";
       $router=new Router($path);  
       $router->Check($request->Url());
       
    }
    /**
     * lance l'application avec les composants de symfony
     */
    public function HandleBySymfonyComponent(HttpFoundationRequest $request,Response $response,RouteCollection $routes)
    {
       // Debugger::Dump('fff');

        $context=new RequestContext();
        $context->fromRequest($request);
        $matcher=new UrlMatcher($routes,$context);
        
        try {

            $resultat=$matcher->match($context->getPathInfo());
            $request->attributes->add($resultat);
            $className=substr($resultat['_controller'],0,strpos($resultat['_controller'],'@'));
            $method=substr($resultat['_controller'],strpos($resultat['_controller'],'@') + 1);
            $controller=[new $className($request,$response,$routes),$method];
            $res=call_user_func($controller);
            return $res;
        } catch (ResourceNotFoundException $e) {
            $controller=new Controller($request,$response,$routes);
            return $controller->To404();
        }
    }
}

