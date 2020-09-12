<?php
use App\App;
use Delight\Auth\Auth;
use function \DI\{create,factory};
use Psr\Container\ContainerInterface;

$db=App::getdb();

return [
    "site.name" => "http://blog.test",
    Auth::class => factory(function (ContainerInterface $c) use ($db){
        return new Auth($db);
    })
];
