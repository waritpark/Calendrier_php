<?php
session_start();
if($_SESSION['role_user']!=1) {
    header('location:../../Forms/connexion.php');
}

require '../../App/bdd.php';
require '../../Public/utility.php';
require '../../Calendar/Event.class.php';
require '../../Calendar/Events.class.php';
require '../../Calendar/Validator-event.class.php';

$pdo = get_pdo();
$events = new Calendrier\Events($pdo);
$event = $events->DeleteUser($_GET['id_user']);
header("location:http://localhost/base-learn/Views/calendar/stats.php?supp=1"); 
 
?>
