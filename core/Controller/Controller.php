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
    /**
     * Request | peut etre de httpFondation ou speeder\Request
     */
    protected $request;
    protected $response;
    protected $twig;
    protected $manager;
    private $routes;
    /**
     * conteneur de gestion de dépendances
     */
    protected $container;

    public function __construct($request,$response,$routes,$container)
    {
        $this->request=$request;
        $this->response=$response;
        $this->routes=$routes;
        $this->container=$container;
        //chargement de la configuration de doctrine
        include AppKernel::GetProjectDir().AppKernel::Ds().'config'.AppKernel::Ds().'bootstrap.php';
      
        $path=AppKernel::GetProjectDir().AppKernel::Ds(). "Templates";
        $loader = new \Twig\Loader\FilesystemLoader($path);
        $this->twig = new \Twig\Environment($loader,['debug'=>true]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->extends2();
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
        ob_start();
        if($vars){
           // Debugger::Dump($vars);
            echo $this->twig->render($views, $vars);
        }else{
            echo $this->twig->render($views);
        }
        $content=ob_get_clean();
        $this->response->SetContent($content);
        return $this->response;
    }
    /**
     * Rends une vue en utilisant la classe response de symfony
     * méthode à adapter plus tard avec twig
     */
    public function RenderBySymfony(){
        return 0;
    }
    /**
     * Rends une réponse json
     * @param string $views la vue à afficher
     * @param array $vars les variables à passer à la vue
     */
    public function JsonResponse($vars=[])
    {
        $json=json_encode($vars);
        ob_start();
        echo $json;
        $content=ob_get_clean();
        $this->response->SetContent($content);
        //modifier le content-type de la reponse pour specifier un renvois du json
        return $this->response;
    }

    public function To404()
    {
       return $this->RenderByTwig('Error/404.html');
    }

    /** 
     * ajoute la fonction Speederpath() à twig
    */
    private function extends()
    {

       $functionSpeederPath = new \Twig\TwigFunction('SpeederPath', function ($name,$params=[]) 
        {
        
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


        $this->twig->addFunction($functionSpeederPath);
        //Ajouter ici la nouvelle fonction de gestion des liens à twig
    }
    /**
     * 
     */
    private function extends2(){
        $speederPath=new \Twig_Function('SpeederPath',function($name,$separator='/',$params=[]){
          $url='';
          $routes=$this->routes->all();

           if (count($params)<1) {

            
            $pathPatern=$routes[$name]->getPath();

           } else 
           {
            $pathPatern=substr($routes[$name]->getPath(),0,strpos($routes[$name]->getPath(),'{')-1).$separator.implode($separator,$params);
               // Debugger::Dump('hhhhhh');
           }
           
           return $pathPatern;

        });
        $this->twig->addFunction($speederPath);
    }

}
