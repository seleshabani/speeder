<?php
namespace Speeder\Console;

class Writer
{
    
    /**
     * le code a insere dans le controller
     *
     * @param string $controller
     * @return string
     */
    public static function WriteInController($controller)
    {
        return "<?php \n
        namespace App\Controller; \n 
        use Speeder\Controller\Controller; \n 
        /**
         * generer par Consolino de Speeder-Framework
         * @author sele shabani <seleshabani4@gmail.com>
         */\n
        class $controller extends Controller
        {\n
            public function index()\n
            {\n 
                //this->Render('');\n
            }\n
     }";
    }

    public static function WriteInManager($name)
    {
        return "<?php \n
        namespace App\Manager; \n 
        use Speeder\Database\Manager; \n 
        use Speeder\Builder\QueryBuilder;\n
        /**
         * generer par Consolino de Speeder-Framework
         * @author sele shabani <seleshabani4@gmail.com>
         */\n
        class " . $name . "Manager extends Manager
        {
        
        }";
    }

    public static function WriteInEntity($name,$cols=[])
    {
        $seters='';
        $geters='';
        $attr='';
        for ($k=0; $k < count($cols) ; $k++) {
            if (preg_match("#id#i",$cols[$k])) {
                $attr .= "/** @Id @Column(type=\"integer\") @GeneratedValue **/\n
                protected $$cols[$k];";
            }else{
                $attr .= "/** @Column(type=\"\") **/
                protected $$cols[$k];";
            }
        }


        return '<?php
        namespace App\Entity; 
        use Speeder\Database\Entity; 
        /**
         * generer par Consolino de Speeder-Framework
         * @author sele shabani <seleshabani4@gmail.com>
         */

          /**
         * @Entity @Table(name="'.$name.'")
         **/
        
        class '. $name .' extends Entity
        {'.
            $attr
        
       . '}';
    }

     public static function WriteInFixture($name)
    {
       

        return '<?php
        namespace App\Fixture; 
        use function Speeder\Debug\Dump;
        use Speeder\Fixture\MakeFixture; 
        use Faker\Factory;
        /**
         * generer par Consolino de Speeder-Framework
         * @author sele shabani <seleshabani4@gmail.com>
         */

        
        class '. $name .' extends MakeFixture
        {
            function Make()
            {

            }
        }';
    }
}
