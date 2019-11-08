<?php
namespace Speeder\Component\Security;

class Auth
{
    public function Passverif($last,$hach){
		if (password_verify($last,$hach)) {
    		return true;
		}else {
    		return false;
		}
	}
}
