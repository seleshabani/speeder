<?php
use Twig\Environment;
use Speeder\Kernel\AppKernel;
use Twig\Loader\FilesystemLoader;
use function \DI\{create,factory};
use Psr\Container\ContainerInterface;
use Speeder\Controller\Controller;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use \Twig\Extension\DebugExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



return [
    '_routes' => require 'Routes.php',
    '_template.path' => AppKernel::GetProjectDir().AppKernel::Ds(). "Templates",
    RequestContext::class => create(),
    UrlMatcher::class => factory(function (ContainerInterface $c){
        return new UrlMatcher($c->get('_routes'),$c->get(RequestContext::class));
    }),
    FilesystemLoader::class=> factory(function (ContainerInterface $c){
      return new FilesystemLoader($c->get('_template.path'));
    }),
    Environment::class => factory(function(ContainerInterface $c){
        $twig = new Environment($c->get(FilesystemLoader::class),['debug'=>true]);
        $twig->addExtension($c->get(DebugExtension::class));
        $speederPath=$c->get('extends.twig');
        $twig->addFunction($speederPath);
        return $twig;
    }),
    DebugExtension::class => create(),
    Request::class => factory(function (){
        return Request::createFromGlobals();
    }),
    Response::class => create(),
    Controller::class => factory(function (ContainerInterface $c){
        return new Controller($c->get(Request::class),$c->get(Response::class),$c->get('_routes'),$c);
    }),
    'extends.twig' => function (ContainerInterface $c){

        $speederPath = new \Twig\TwigFunction('SpeederPath',function($name,$separator='/',$params=[]) use ($c){
            $url='';
            $routes = $c->get('_routes')->all();
  
             if (count($params)<1) {
  
              
              $pathPatern=$routes[$name]->getPath();
  
             } else 
             {
              $pathPatern=substr($routes[$name]->getPath(),0,strpos($routes[$name]->getPath(),'{')-1).$separator.implode($separator,$params);
                 // Debugger::Dump('hhhhhh');
             }
             
             return $pathPatern;
  
          });
          return $speederPath;
    },
    'doctrine.config' => require AppKernel::GetProjectDir().AppKernel::Ds().'config'.AppKernel::Ds().'bootstrap.php',
];