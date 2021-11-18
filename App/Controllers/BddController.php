<?php

namespace App\Controllers;

use PDO;

class BddController 
{
    public function get_pdo():PDO {
        return new PDO('mysql:host=localhost;dbname=bdd_calendrier', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

    }


}
?>