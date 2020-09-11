<?php
namespace Speeder\InjectionContainer;

use Psr\Container\ContainerInterface;
use Speeder\Debug\Debugger;

/**
 * cette classe sert de décorateur au conteneur de gestion de dépendances pour pas que le framework
 * dépendes de lui;
 * suit la meme structure du psr-7 sans implémenter son interface
 */

class Container
{
  
    /**
    *le container utilisé
    */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container=$container;
    }

     /**
     * Renvois un objet en utilisant la clé par laquelle elle a été enrégistré
     *
     * @param string $id Identifie un objet
     *
     * @throws NotFoundExceptionInterface  Aucun ojet n'a été trouvé.
     * @throws ContainerExceptionInterface Une erreur s'est produite.
     *
     * @return mixed l'objet demandé.
     */
    public function get($id){
        try {

            return $this->container->get($id);

        } catch (\Throwable $th) {
            Debugger::RDump('Une erreur est survenue : '.$th);
        }
    }

    /**
     * Returns true si le container contient l'objet recherché
     * Returns false si l'objet n'existe pas.
     *
     * `has($id)` qui retourne true ne veut pas dire que `get($id)` ne retournera pas d'exception.
     * Cela signifie cependant que `get($id)` n'enverra pas de `NotFoundExceptionInterface`.
     *
     * @param string $id Identifie l'objet demandé.
     *
     * @return bool
     */
    public function has($id){

        return $this->container->has($id);
    }


}
