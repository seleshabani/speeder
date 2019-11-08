<?php
namespace App\Controller;
use App\Entity\lolo;
use function Speeder\Debug\Dump;
use Speeder\Builder\QueryBuilder;
use Speeder\Controller\Controller;
use Speeder\Annotation\MetadataForMethod;

class DefaultController extends Controller
{
    /**
     * @Route=/blog/:id/:news
     * @length=50
     */
    public function index()
    {
      $this->RenderByTwig("Default/index.html");
    }
    /**
     * @Route="/about"
     */
    public function about()
    {
       $this->RenderByTwig("Default/about.html");
    }

    
}
