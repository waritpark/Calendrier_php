<?php



try {
    $pdo = new PDO('mysql:host=localhost;dbname=bdd_calendrier', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}

function get_pdo() {
    return new PDO('mysql:host=localhost;dbname=bdd_calendrier', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

}



?>