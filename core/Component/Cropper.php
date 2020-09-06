<?php
namespace Speeder\Component;
use Speeder\Kernel\AppKernel;
use function Speeder\Debug\Dump;
use Speeder\Http\Parameter\FileParameter;
/**
 * 
 */
class Cropper{
	private $source;
	private $dest;
	private $sourcex;
	private $sourcey;
	private $destx;
	private $desty;
	private $dir;/* dossier d'enregistrment final du fichier */
	private $name;/* nom du fichier */

	/**
	 * Undocumented function
	 *
	 * @param [type] $dir dossier dans lesquels le fichier est enregistrer
	 * @param [type] $image le nom de l'image
	 */
	public function __construct($dir,FileParameter $image){
		
		$this->dir=AppKernel::GetProjectDir().AppKernel::Ds().'Ressource'.AppKernel::Ds().'thumbs'.AppKernel::Ds();
		$this->name=$image['name'];
		$dir=AppKernel::GetProjectDir().AppKernel::Ds().'Ressource'.AppKernel::Ds().str_replace('.',AppKernel::Ds(),$dir).AppKernel::Ds();

		if($this->type($image['name'])=='png'){

			$this->source= imagecreatefrompng($dir.$image['name']);

		}elseif ($this->type($image['name'])=='jpg' || $this->type($image['name'])=='jpeg' || $this->type($image['name'])=='JPG' ) {
			
			$this->source= imagecreatefromjpeg($dir.$image['name']);

		}else{
			Dump('Le type de l\'image ne pas pris en compte');
			
		}
	}

	/**
	 * initialise les nouvelles dimensions de l'image
	 *
	 * @param [type] $destx nouvelle largeur
	 * @param [type] $desty nouvelle longuer
	 * @return void
	 */
	public function load($destx,$desty){
		$this->sourcex = imagesx($this->source);
		$this->sourcey = imagesy($this->source);
		$this->dest = imagecreatetruecolor($destx,$desty);
		$this->destx = imagesx($this->dest);
		$this->desty= imagesy($this->dest);	
		
	}

	/**
	 * Undocumented function
	 * @param [type] $dir un sous dossier du dossier Ressource/thumbs
	 * @return boolean
	 */
	public function croppe($dir=null){
		
		imagecopyresampled($this->dest, $this->source, 0, 0, 0, 0,$this->destx, $this->desty, $this->sourcex,$this->sourcey);
		// On enregistre la miniature
		if($dir==null){
			imagejpeg($this->dest,$this->dir.AppKernel::Ds().$this->name);
		}else{
			imagejpeg($this->dest,$this->dir.$dir.$this->name);
		}
		
		return true;
	}

	public function type($image){
		
		return substr($image,-3);
	}

}