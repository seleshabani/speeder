<?php
use App\App;
use Speeder\Debug\Debugger;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;

require '../vendor/autoload.php';
$routes=require '../config/Routes.php';

$request=HttpFoundationRequest::createFromGlobals();
$response=new Response();
Debugger::Init($request,$response,$routes);

$app=new App('../config/env.json');
 //$app->Handle($request);
 
 $response=$app->HandleBySymfonyComponent($request,$response,$routes);
 $response->send();