<?php 
session_start();
if($_SESSION['pseudo']=="") {
    header('location:../../Forms/connexion.php');
}
?>
<?php require_once '../../Calendar/Events.class.php'; ?>
<?php require_once '../../Public/utility.php'; ?>
<?php require_once '../../App/bdd.php'; ?>
<?php 

$pdo = get_pdo();
$events = new Calendrier\Events($pdo); 
try {
    $event = $events->findInUrlId($_GET['id_event']) ?? null;
}
catch (\Exception $e) {
    e404();
}
catch (\Error $e) {
    e404();
}

?>
<?php require_once '../../Views/includes/header.php'; ?>

    <?= var_dump($event);?>



<?php include('../../Views/includes/footer.php'); ?>