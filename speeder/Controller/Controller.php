<?php
namespace Speeder\Controller;

use Speeder\Kernel\AppKernel;
use Speeder\Debug\Debugger;
use Speeder\Http\Request;
use function Speeder\Debug\Dump;
/**
 * Controller de base
 */
class Controller
{

    protected $request;
    protected $twig;
    protected $manager;

    public function __construct(Request $request)
    {
        $this->request=$request;
        //chargement de la configuration de doctrine
        include AppKernel::GetProjectDir().AppKernel::Ds().'config'.AppKernel::Ds().'bootstrap.php';
      
        $path=AppKernel::GetProjectDir().AppKernel::Ds(). "Templates";
        $loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($loader);
        $this->extends();
        $this->manager=$entityManager ;
    }

    /**
     * Retourne une vue html a l'utilisateur
     * @param string $views
     * @param array $vars
     * @return void
     */
    public function Render($views,$vars=[])
    {
       // require '../../autoload.php';
        extract($vars);
          ob_start();
          require(AppKernel::GetProjectDir().AppKernel::Ds().'Templates'.AppKernel::Ds().$views.'.php');
          $content = ob_get_clean();
          require(AppKernel::GetProjectDir() . AppKernel::Ds() . 'Templates' . AppKernel::Ds()."base.php");
    
        
    }

    /**
     * Rends une vue en utilisant twig
     * @param string $views la vue à afficher
     * @param array $vars les variables à passer à la vue
     */
    public function RenderByTwig($views,$vars=[])
    {
        if($vars){
            echo $this->twig->render($views, $vars);
        }else{
            echo $this->twig->render($views);
        }
        
    }

    public function JsonResponse($var=[])
    {
        $json=json_encode($vars);
        echo $json;
        //modifier le content-type de la reponse pour specifier un renvois du json
        die();
    }

    public function To404()
    {
        $this->RenderByTwig('Error/404.html');
    }

    /** 
     * ajoute la fonction path() à twig
    */
    private function extends()
    {

       $function = new \Twig_Function('path', function ($name,$params=[]) {
        
            $path= AppKernel::GetProjectDir().AppKernel::Ds().'config'.AppKernel::Ds().'Route.json';
            $handle=file_get_contents($path);
            $routes=json_decode($handle);
            $t='';
            $m=2;
            foreach ($routes as $k =>$v) {
                
                  if(property_exists($v,"name")){
                        
                    if($v->name==$name){
                        if(property_exists($v,"params")){
                        
                        $infos=explode($v->ls,$v->url);
                        
                        for ($l=0; $l < count($params); $l++) { 
                           
                            $t.=$v->ls.$params[$l];
                       
                        }
                        return '/'.$infos[0].$infos[1].$t;
                   
                        }else{
                            
                            return $v->url;
                        }
                    }
                  }
            }
         });
        $this->twig->addFunction($function);
    }


}
