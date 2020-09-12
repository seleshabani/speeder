<?php
namespace Speeder\Console;

use Speeder\Debug\Debugger;
use App\App;
use function Speeder\Debug\Dump;
use Speeder\Database\Database;
use Speeder\QueryBuilder\QueryBuilder;

/**
 * classe gerant la console
 * @author sele shabani <seleshabani4@gmail.com>
 */
class Application
{
    /**
     * argument envoyer au script
     * @var array
     */
    protected $args=[];

 /**
  * Undocumented function
  *
  * @param array $var
  * @return void
  */ 
    public function SetArgs($var =[])
    {
        $this->args=$var;
    }

    /**
     * Recupere l'argument passer au script
     *
     * @return mixed
     */    
    public function GetArgs()
    {
        return $this->args;
    }


    /**
     * Teste la valeur envoyer en argument a la console
     */
    public function Check()
    {
        switch ($this->args[1]) {
            case 'make:controller':
            $this->MakeController();
                break;
            case 'make:table':
            $this->MakeTable();
                break;
            case 'make:entity':
            $this->MakeEntity();
                break;
            case 'make:fixture':
            $this->MakeFixture();
                break;
            case 'help':
            $this->Help();
                break;
            default:
                
                break;
        }
    }

    public function Help()
    {
        echo "
        Bienvenue dans l'aide de consolineo l'outil de ligne de commande pour speeder-framework.\n
        -Auteur:Sele Shabani \n
        commandes\n
        ---------\n
        make:controller:cree un controller et son dossier des vues \n
        make:table:cree une table dans votre bdd et son manager ainsi que son entite cote php \n
        make:entity:cree une entite utilisable avec doctrine
        help:affiche l'aide
        ";
    }

    /**
     * cree un controller et y insere le code initial
     *
     * @return void
     */
    public function MakeController()
    {
        echo "Entrez le nom du controller(MangaController) \n";
        $reponse = fgets(STDIN);
       $name=str_replace("Controller","",\trim($reponse));

         while (!preg_match("#^[A-Za-z]+Controller$#",$reponse)) {
             echo "Entrez un nom valide \n";
             $reponse = \trim(fgets(STDIN));
        }
        
        $path= App::GetProjectDir().App::Ds()."App".App::Ds()."Controller".App::Ds().$reponse.".php";
        $path_directory_templates=App::GetProjectDir().App::Ds()."Templates".App::Ds().$name;
        $handle=fopen($path,'a+');
        $text=Writer::WriteInController($reponse);
        file_put_contents($path, $text); 
        touch($path);
        mkdir($path_directory_templates,0777,true);
        echo $reponse." creer avec succee modifiez le dans App/Controller/ \n";
        echo "editez vos vues dans ".$path_directory_templates;

    }

    /**
     * Cree une table dans la base de donnees et les managers et entites php qui vont avec
     *
     * @return void
     */
    public function MakeTable()
    {
        $db = $this->GetDb();
        $object = $this->GetEnv();
        $db_i = $object->db_infos;
        echo "Entrez le nom de la table (MaTable) \n";
        $name = fgets(STDIN);
        while (!preg_match("#^[A-Za-z]#", $name)) {
            echo "Entrez un nom valide \n";
            $name = fgets(STDIN);
        }

        $rep="y";
        while (preg_match("#y#i",$rep)) {

            echo "Entrez une collone \n";
            $colname = str_replace(" ","", fgets(STDIN));
            $cols[] = $colname;
            echo "Entrez son type \n";
            $type = fgets(STDIN);
            $params[] = $colname.' '.\trim($type);
            echo "Voulez vous ajoutez une autre collone a cette table?(y/n) \n";
            $rep = fgets(STDIN);

         }

        $qb = new QueryBuilder();
        $name=\trim($name);

        $req = $db->query($qb->Create($name, $params)); 
        $pathtomanager = App::GetProjectDir() . App::Ds() . "App" . App::Ds() ."Manager" . App::Ds() .$name. "Manager.php";
        $pathtoentity = App::GetProjectDir() . App::Ds() . "App" . App::Ds() . "Entity" . App::Ds() .$name. "Entity.php";

        $textformanager = Writer::WriteInManager($name);
        $textforentity = Writer::WriteInEntity($name,$cols);

        file_put_contents($pathtomanager, $textformanager); 
        file_put_contents($pathtoentity, $textforentity); 
        echo "Votre Table ".$name." a ete creer avec succee!";
      
    }

    /**
     * cree une classe entite utilisable avec doctrine facilement
     */
    public function MakeEntity()
    {
        echo "Entrez le nom de l'entite \n";
        $name=fgets(STDIN);
        while (!preg_match("#^[A-Za-z]#", $name)) {
            echo "Entrez un nom valide \n";
            $name = fgets(STDIN);
        }

        $rep="y";
        while (preg_match("#y#i",$rep)) {

            echo "Entrez une collone \n";
            //$colname = str_replace(" ","", fgets(STDIN));
            $cols[]=\trim($colname);
            echo "Voulez vous ajoutez une autre collone a cette table?(y/n) \n";
            $rep = fgets(STDIN);

         }
        $name = \trim($name);
        $pathtoentity = App::GetProjectDir() . App::Ds() . "App" . App::Ds() . "Entity" . App::Ds() . $name . ".php";
        $pathtofixture = App::GetProjectDir() . App::Ds() . "App" . App::Ds() . "Fixture" . App::Ds() . $name . ".php";
        $textforentity=Writer::WriteInEntity($name,$cols);
        $textforfixture=Writer::WriteInFixture($name);
        file_put_contents($pathtoentity, $textforentity); 
        file_put_contents($pathtofixture, $textforfixture); 
        echo $name." a ete creer avec succee!";
    }

    public function MakeFixture()
    {
        echo "Entrez le nom de l'entite \n";
        $name=fgets(STDIN);
        while (!preg_match("#^[A-Za-z]#", $name)) {
            echo "Entrez un nom valide \n";
            $name = fgets(STDIN);
        }

        $n=\trim($name);
        $name='\\App\\Fixture\\'.$n;
        $fixture=new $name();
        if(is_callable([$fixture,'make'])){
            $fixture->make();
        }
    }

    /**
     * Connexion a la base de donnees
     */

    public function GetDb()
    {
        $object=$this->GetEnv();
        $dsn = $object->db_infos->dsn;
        $user = $object->db_infos->user;
        $password = $object->db_infos->password;
        try {
            $db = new \PDO($dsn, $user, $password);
            return $db;
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    public function GetEnv()
    {
        $path = $path = App::GetProjectDir() . App::Ds() . 'config' . App::Ds() . 'env.json';
        $content = file_get_contents($path);
        $object = json_decode($content);
        return $object;
    }
}
