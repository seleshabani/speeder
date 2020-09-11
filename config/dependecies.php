<?php
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use function \DI\{create,factory};

return [
    '_routes'=>require 'Routes.php',
    RequestContext::class => create(),
    UrlMatcher::class => factory(function (ContainerInterface $c){
        return new UrlMatcher($c->get('_routes'),$c->get(RequestContext::class));
    })
];