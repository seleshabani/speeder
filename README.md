Speeder-Framework
========================

Un petit framework à usage personnel,parfait pour des petits projets


## Configuration

-lisez et modifiez le fichier `config/app.php` pour configurer le framework
-modifiez vos routes dans les fichiers `Config/Route.json` ou dans `Config/Routes.php`(pour utiliser symfony/routing)
-si le separateur des paramatres est / les index doivent commencer a deux (Dans le cas du premier choix pour le routing)
-le fichier `config/env.json` va servir a definir les variables d'environnement global
-les dépendances du projets sont à definir dans les  fichiers `Config.php` et `Config/Dependencies.php` (elles sont gerés par https://github.com/PHP-DI/PHP-DI)
-la gestion de l'authentification des utlisateurs est fait par https://github.com/delight-im/PHP-Auth
## CONSOLINEO

-consolineo est l'outil de ligne de commande qui vous permet d'automatiser vos taches

`php bin/console help`
