<?php
namespace Speeder\Http;
use Speeder\Debug\Debugger;
use Speeder\Kernel\AppKernel;
use Speeder\Http\ParameterBag;
use Speeder\Http\Parameter\GetParameter;
use Speeder\Http\Parameter\PostParameter;
use Speeder\Http\Parameter\CookieParameter;
use Speeder\Http\Parameter\SessionParameter;
use Speeder\Http\Parameter\FileParameter;
use function Speeder\Debug\Dump;
/**
 * Classe Request represente la requette http du client
 * @author sele shabani <seleshabani4@gmail.com>
 */
class Request 
{
    /**
     * url 
     */

     protected $url;

     /**
      * cookies($_COOKIE)
      *  @var \Speeder\Http\ParameterBag
      */

     public $cookies;

     /**
      * querys($_GET)
      * @var \Speeder\Http\Parameter\GetParameter
      */
     public $querys;
   
     /**
      * request($_POST)
      *  @var \Speeder\Http\ParameterBag
      */
      public $request;

      /**
       * file($_FILES)
       * @var \Speeder\Http\ParameterBag
       */
      public $files;

      /**
       * session($_SESSION)
       * @var \Speeder\Http\ParameterBag
       */
      public $session;

      /**
       * server($_SERVER)
       * @var \Speeder\Http\ParameterBag
       */
     public $server;

      /**
       * methode represente la méthode utilisé actuellement pour appeler le site
       */
      protected $method;

     /**    
      * cree une requete en appelant la methode initisalise
      */

      public function __construct()
      {
        $this->Initialise($_COOKIE,$_GET,$_POST,$_FILES,$_SESSION,$_SERVER);   
      }

      /**
       * enregistre les parametres http dans des objets de type parametersbag
       *
       * @param [array()] $cookies
       * @param [array()] $querys
       * @param [array()] $request
       * @param [array()] $files
       * @param [array()] $session
       * @param [array()] $server
       * @return void
       */
      public function Initialise($cookies,$querys,$request,$files,$session,$server)
      {
          $this->cookies=new CookieParameter($cookies);
          $this->querys=new GetParameter($querys);
          $this->request=new PostParameter($request);
          $this->files=new FileParameter($files);
          $this->session=new SessionParameter($session);
          $this->server=new ParameterBag($server);
          $this->url=$this->server->get("REQUEST_URI");
          $this->method=$this->server->get("REQUEST_METHOD");
      }

      /**
       * 
       */
      public function Has($method)
      {
        if($this->Method()==$method){
          return true;
        }else{
          return false;
        }
      }
      /**
       * retourne la methode de la requete Http
       */
      function Method()
      {
        return $this->method;
      }

      /**
       * 
       */
      public function Url()
      {
        return $this->url;
      }

      /**
       * fonction upload,uploade les fichiers sur le serveur
       *
       * @param [type] $key nom de l'input file
       * @param array $format format supporter
       * @param [type] $dir dossier de destination
       * @param [type] $prefixe prefixe a donner au fichier
       * @return void
       */
      public function Uploads($key, $format = [], $dir=null, $prefixe = null)
      {

      
         
        if ($this->files->Exist($key)) {
          
          if (in_array(substr($this->files->Get($key)['name'], -3), $format)) {
         
              $tmp = $this->files->Get($key)['tmp_name'];
              
              if ($dir==null) {
                  $upload_dir = AppKernel::GetProjectDir().AppKernel::Ds().'Ressource'.AppKernel::Ds();
              }else{
                  $upload_dir = AppKernel::GetProjectDir().AppKernel::Ds().'Ressource'.AppKernel::Ds().$dir.AppKernel::Ds();
              } 


            if ($prefixe === null) {
              $content = $upload_dir . str_replace(' ', '-', $this->files->Get($key));
              if (move_uploaded_file($tmp, $content)) {
                 return true;
              } else {
                return false;
               }
            } else {
             $content = $upload_dir . $prefixe.str_replace(" ","-",$this->files->Get($key)['name']);
              if (move_uploaded_file($tmp, $content)) {
                 return true;
              } else {
                return false;
              }
            }
          } else {
           return false;
          }  
        }else{
          Dump($this->files->All());
        }

      }

      /**
       * recupère une valeur contenue dans un tableau
       *
       * @param string $params
       * @param string $key
       * @return mixed
       */
       public function Get($params,$key)
      {
        $retVal = (isset($this->$params)) ? $this->$params->Get($key) : false ;
        return $retVal;
      }

      /**
       * met à jour une valeur contenue dans un tableau
       *
       * @param string $params
       * @param string $key
       * @param mixed $value
       * @return boolean
       */
       public function Set($params,$key,$value)
      {
        $retVal = (isset($this->$params)) ? $this->$params->Set($key,$value) : false ;
        return $retVal;
      }
 }
