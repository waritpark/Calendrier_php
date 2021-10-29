<?php
session_start();
if($_SESSION['pseudo']=="") {
    header('location:../Forms/connexion.php');
}

require '../App/bdd.php';
require '../Public/utility.php';
require '../Calendar/Event.class.php';
require '../Calendar/Events.class.php';
require '../Calendar/Validator-event.class.php';

$pdo = get_pdo();
$events = new Calendrier\Events($pdo);

try {
    $event = $events->deleteDate($_GET['id_event'] ?? null);
    header("location:".  $_SERVER['HTTP_REFERER']); 
} 
catch (\Exception $e) {
    e404();
}
catch (\Error $e) {
    e404();
}
?>
