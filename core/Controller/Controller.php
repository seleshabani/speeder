<?php
namespace Speeder\Controller;

use Loader;
use Speeder\Http\Request;
use Speeder\Debug\Debugger;
use Speeder\Kernel\AppKernel;
use function Speeder\Debug\Dump;
/**
 * Controller de base
 */
class Controller
{
    /**
     * Request | peut etre de httpFondation ou speeder\Request
     * @var Symfony\Component\HttpFoundation\Request | speeder\Http\Request
     */
    protected $request;

    /**
     * 
     * @var Symfony\Component\HttpFoundation\Response | speeder\Http\Request
     */
    protected $response;

    /**
     * 
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * le manager de doctrine pour la base des données
     * @var Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * 
     */
    private $routes;

    /**
     * conteneur de gestion de dépendances
     * @var Speeder\InjectionContainer\Container
     */
    protected $container;

    public function __construct($request,$response,$routes,$container)
    {
        $this->request=$request;
        $this->response=$response;
        $this->routes=$routes;
        $this->container=$container;
        $entityManager = $container->get('doctrine.config');
        $this->twig = $container->get(\Twig\Environment::class);
        $this->manager = $entityManager ;
    }

    /**
     * Retourne une vue html a l'utilisateur
     * @param string $views
     * @param array $vars
     * @return void
     */
    public function Render($views,$vars=[])
    {
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
}
