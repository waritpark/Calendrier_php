<?php

require ('../../vendor/autoload.php');
$router = new AltoRouter();

$router->map('GET', '/', 'accueil');
$router->map('GET', '/Forms/connexion.php', 'connexion');
$router->map('GET', '/Forms/inscription.php', 'inscription');


$match = $router->match();
if ($match !== null) {
    require '../../Views/includes/header.php';
    if(is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $params = $match['params'];
        require '../../Views/'.$match['target'].'.php';
    }
    require ('../../Views/includes/footer.php');
}


