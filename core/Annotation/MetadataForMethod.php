<?php
namespace Speeder\Annotation;

use mindplay\annotations\AnnotationCache;
use mindplay\annotations\Annotations;
use function Speeder\Debug\Dump;


class MetadataForMethod
{
    protected $object;
    protected $property;
    protected $value;
    protected $comments;
    protected $reflexion;
    protected $metas;

   public function __construct($class,$method='index')
   {
       $this->reflexion=new \ReflectionMethod($class,$method);
       $this->SetComment();
       $this->Parse();
   }

   public function SetComment()
   {
        $this->comments= $this->reflexion->getDocComment();
   }

   public function Parse()
   {
       $r=str_replace('/**','',$this->comments);
       $r=str_replace('*','',$r);
       $r=\explode('@',$r);

       for ($i=0; $i < count($r) ; $i++) { 
           $this->metas[]=$r[$i];
            //\explode('=',$r[$i+1]));
       }

      
   }

   public function Get($meta)
   {
       $bol=false;
       for ($i=0; $i < count($this->metas) ; $i++) { 
        
            if(preg_match('#^'.$meta.'#i',$this->metas[$i])){
                
              $tabofv=\explode('=',$this->metas[$i]);
              $value=\ltrim($tabofv[1]);
              $bol=true;
            }
            
       }

       if($bol){
           return \rtrim($value);
       }else{
           return false;
       }
   }
}
