<?php

require './App/autoloader.php'; 

App\Autoloader::register();

if(isset($_GET['app'])) {
    $app = $_GET['app'];
} else {
    $app = 'accueil';
}

ob_start();
if($app === 'accueil') {
    require ''.__DIR__.'/Views/accueil.php';
}
elseif ($app === 'connexion') {
    require ''.__DIR__.'/Forms/connexion.php';
}
elseif ($app === 'inscription') {
    require ''.__DIR__.'/Forms/inscription.php';
}
elseif ($app === 'dashboard') {
    require ''.__DIR__.'/Views/calendar/dashboard.php';
}
elseif ($app === $_GET['date']) {
    require ''.__DIR__.'/Views/calendar/day-evenement.php';
}
elseif ($app === 'new-evenement') {
    require ''.__DIR__.'/Views/calendar/ajout-evenement.php';
}
elseif ($app === 'my-account') {
    require ''.__DIR__.'/Views/users/compte-user.php';
}
elseif ($app === 'deconnexion') {
    require ''.__DIR__.'/Views/accueil.php';
}
elseif ($app === 'statistiques') {
    require ''.__DIR__.'/Views/users/stats.php';
}
$content = ob_get_clean();

require './Views/template.php';