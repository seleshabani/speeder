<?php

namespace App;

use Speeder\Kernel\AppKernel;
use Speeder\Http\RequestMatcher;
use Speeder\Component\Routing\Route;
use Speeder\Component\Routing\Router;
use Speeder\Http\Request;
use Speeder\Debug\Debugger;


class App extends AppKernel
{
    
    public function Handle(Request $request)
    {
       $path=$this->GetProjectDir().$this->Ds()."config/Route.json";
       $router=new Router($path);  
       $router->Check($request->Url());
       
    }
}

