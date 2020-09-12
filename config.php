<?php
use App\App;
use Delight\Auth\Auth;
use function \DI\{create,factory};
use Psr\Container\ContainerInterface;

$db=App::getdb();

return [
    "site.name" => "http://adresse_site",
    Auth::class => factory(function (ContainerInterface $c) use ($db){
        return new Auth($db);
    })
];
