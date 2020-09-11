<?php
namespace App\Controller;
use Speeder\Controller\Controller;
use Speeder\Debug\Debugger;

class DefaultController extends Controller
{
    /**
     * @Route=/blog/:id/:news
     * @length=50
     */
    public function index()
    {
     return $this->RenderByTwig("Default/index.html");
    }
    /**
     * @Route="/about"
     */
    public function about()
    {
      return $this->RenderByTwig("Default/about.html");
    }
    /**
     * @Route="/hello"
     */
    public function hello()
    {
     
      $v=$this->request->attributes->all();
      return $this->RenderByTwig('Default/hello.html',$v);
    }

    
}
