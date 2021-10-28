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
?>

<?php 
// pour ajouter un evenement
$errors = [];
$data = [
    'date' => $_GET['date'] ?? date('Y-m-d')
];
$validator = new App\Validator($data);
if(!$validator->validate('date', 'date')) {
    // e404();
    $data['date'] = date('Y-m-d');
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendrier\ValidatorEvent($data);
    $errors=$validator->validates($_POST);
    if (empty($errors)) {
        $event = new \Calendrier\Event();
        $event->setName($data['nom']);
        $event->setDesc($data['desc']);
        $event->setStart(DateTime::createFromFormat('Y-m-d H:i', $data['date']. ' ' .$data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(DateTime::createFromFormat('Y-m-d H:i', $data['date']. ' ' . $data['end'])->format('Y-m-d H:i:s'));
        debug($event);
        $events = new \Calendrier\Events(get_pdo());
        $events->create($event);
        header('Location:../Views/dashboard.php?success=1');
        exit();
    }
}
?>

<?php  
// pour afficher les evenements du jour
$pdo = get_pdo();
$events = new Calendrier\Events(get_pdo());
$date = $_GET['date'];
$start = new DateTime($_GET['date']);
$events = $events->getEvents($start);
$day = new DateTime($_GET['date']);
?>

<?php require '../Views/header.php'; ?>

<?php setlocale(LC_TIME, 'fra_fra'); ?>
<div class="row">
    <div class="col-6">
        <h2 class="w-max-content m-0"><?php //echo str_replace('-', ' ', strftime('%A %d %B %Y')); ?></h2>

        <?php foreach($events as $event): ?>
            <div class="container-calendar-event d-flex align-items-center fs-6">
                <div><?= (new DateTimeImmutable($event['start_event']))->format('H:i'); ?>&nbsp;-&nbsp;</div>
                <a class="text-black" href="edit-evenement.php?id_event=<?php echo $event['id_event'];?>"><?php echo $event['nom_event']; ?></a>
                <div>&nbsp;:&nbsp;<?php echo $event['desc_event'];?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-6">
        <legendfield class="h2">Ajout d'un nouvel événement</legendfield>
        <form action="#" method="post" class="mt-4 form-ajout-event">
            <?php render('../Forms/form-evenement.php', ['data'=>$data, 'errors'=>$errors]); ?>
            <button type="submit" class="btn btn-primary mb-4">Ajouter</button>
        </form>
    </div>
</div>


<?php include('../Views/footer.php'); ?>