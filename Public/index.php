<?php
 use Speeder\Http\Request;
 use App\App;
 use Speeder\Debug\Debugger;
 use mindplay\annotations\Annotation;
 use function Speeder\Debug\Dump;
 require '../vendor/autoload.php';
 
 Debugger::Init();
 $app=new App('../config/env.json');
 $request=new Request();
 $app->Handle($request);
 