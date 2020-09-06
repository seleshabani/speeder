<?php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes=new RouteCollection();

$routes->add('home',new Route('/',['_controller'=>'App\Controller\DefaultController@index']));
$routes->add('hello',new Route('/hello/{name}',
['name'=>'sele650','_controller'=>'App\Controller\DefaultController@hello']));
$routes->add('about',new Route('/about',['_controller'=>'App\Controller\DefaultController@about']));

return $routes;
