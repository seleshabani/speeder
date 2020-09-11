<?php
use App\App;
use Speeder\Debug\Debugger;
use DI\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

require '../vendor/autoload.php';
//$routes=require '../config/Routes.php';
$dependences=require '../config/dependecies.php';

//configuration du container externe utilisé
$builder = new ContainerBuilder();
$builder->addDefinitions($dependences);
$Dicontainer=$builder->build();

//création du container interne en lui injectant le conteneur externe installé
$container = new Speeder\InjectionContainer\Container($Dicontainer);

//creation de la request et de la reponse en remplissant la req des informations global
$routes=$container->get('_routes');
$request=HttpFoundationRequest::createFromGlobals();
$response=new Response();

Debugger::Init($request,$response,$routes,$container);

$app=new App($container);//passage du container à l'application
 
 $response=$app->HandleBySymfonyComponent($request,$response,$routes);
 $response->send();