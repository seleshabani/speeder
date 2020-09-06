<?php
namespace Speeder\Kernel;

use Speeder\Debug\Debugger;
use Speeder\Http\Request;
use function Speeder\Debug\Dump;

/**
 * le core de l'application
 * @author sele shabani <seleshabani4@gmail.com>
 */
class AppKernel
{

    protected $pathtodb;

    /**
     * Demarre une session utilisateur
     */
    public function __construct()
    {
        session_start();
        
    }

     /**
     * directory separator
     */

    public static function Ds()
    {
        return DIRECTORY_SEPARATOR;
    }

    /**
     * Recupere le dossier du projet
     */
    public static function GetProjectDir()
    {
        return dirname(dirname(__DIR__));
    }

    /**
     * traite la requete
     */

     public function Handle(Request $request)
     {
         
     }


    /**
     * Etablis une connexion avec la base de donnees
     */
     public static function GetDb()
     {
        $env_parsed=self::GetEnv();
        $dsn= $env_parsed->db_infos->dsn;
        $user= $env_parsed->db_infos->user;
        $password= $env_parsed->db_infos->password;

        try {
            $db = new \PDO($dsn, $user, $password);
            return $db; 
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
     }

    public static function GetEnv()
    {
        $path = $path = self::GetProjectDir() . self::Ds() . 'config' . self::Ds() . 'env.json';
        if(!file_exists($path)){
            throw new \Exception("Fichier introuvable env.json creer le dans /config", 1);
            
        }else{
            $content = file_get_contents($path);
            $object = json_decode($content);
            return $object;
        }
        
    }

}
