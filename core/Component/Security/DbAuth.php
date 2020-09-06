<?php
namespace Speeder\Component\Security;
use Speeder\Component\Security\Auth;
use Speeder\Kernel\AppKernel;
use Speeder\Debug\Debugger;

class DbAuth extends auth
{
    protected $manager;
   	public function __construct(){

		include AppKernel::GetProjectDir().AppKernel::Ds().'config'.AppKernel::Ds().'bootstrap.php';
        $this->manager=$entityManager ;
    }
	
	public function login($name,$password,$table,$key){
        
        $repo= $this->manager->getRepository($table);
        $user=$repo->find($name);
		if(count($user)>=1){
			if (password_verify($password,$user[0]->pass)) {
    		//	return $_SESSION[$key]=$user[0]->id;
			}else {
    		//	return false;
            }
            
		}else{
			return false;
		}
		
	}
	public function logged($key){

		return isset($_SESSION[$key])?true:false;
	}
	public function subscribe($name,$pass,$sexe,$table,$categorie=null){

		//$p =password_hash($pass,PASSWORD_BCRYPT);
	
	}
}
