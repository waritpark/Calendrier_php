<?php require 'events.php'; ?>
<?php require 'debug.php'; ?>
<?php require 'header.php'; ?>

<?php 

$pdo = get_pdo();
$events = new Calendrier\Events($pdo); 
$event = $events->findInUrlId($_GET['id_event']);
?>
    <div class="container">
    <h1>Bonjour</h1>
    <?= debug($event);?>


    </div>
<?php include('footer.php'); ?>