<?php require_once '../Calendar/Events.class.php'; ?>
<?php require_once '../Public/utility.php'; ?>
<?php require_once '../App/bdd.php'; ?>
<?php 

$pdo = get_pdo();
$events = new Calendrier\Events($pdo); 
try {
    $event = $events->findInUrlId($_GET['id_event']);
}
catch (\Exception $e) {
    e404();
}

?>
<?php require_once '../Views/header.php'; ?>

    <?= var_dump($event);?>



<?php include('../Views/footer.php'); ?>