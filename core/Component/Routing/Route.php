<?php
namespace Speeder\Component\Routing;

/**
 * Represente une url enregistrer dans le fichier Route.json
 */
class Route
{
    /**
     * 
     *  @var string
     */
    protected $controller;

    /**
     * 
     *  @var string
     */
    protected $action;

    /**
     * 
     * @var string
     */
    protected $params;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $url;


    /**
     * Represente la route formater grace a la classe routeur et RequestMatcher
     *
     * @param [type] $url
     * @param [type] $controller
     */
    public function __construct($url,$controller)
    {
        $this->controller=$controller;
        $this->url=$url;
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function HasParam()
    {
        
    }
}
