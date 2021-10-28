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
    $event = $events->findInUrlId($_GET['id_event'] ?? null);
} 
catch (\Exception $e) {
    e404();
}
catch (\Error $e) {
    e404();
}
?>
<?php 
$errors = [];
$data = [
    'nom' => $event->getName(),
    'desc' => $event->getDesc(),
    'date' => $event->getStart()->format('Y-m-d'),
    'start' => $event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i')
];

render('header.php', ['title' => $event->getName()]);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendrier\ValidatorEvent($data);
    $errors=$validator->validates($data);
    if (empty($errors)) {
        $event->setName($data['nom']);
        $event->setDesc($data['desc']);
        $event->setStart(DateTime::createFromFormat('Y-m-d H:i', $data['date']. ' ' .$data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(DateTime::createFromFormat('Y-m-d H:i', $data['date']. ' ' . $data['end'])->format('Y-m-d H:i:s'));
        debug($event);
        $events->update($event);
        header('Location:../Views/dashboard.php?modification=1');
        exit();
    }
}
?>
<?php //require '../Views/header.php'; ?>

<legendfield class="h2">Modifier l'événement : <?php echo h($event->getName()); ?></legendfield>
<form action="#" method="post" class="mt-4 form-ajout-event">
    <?php render('../Forms/form-evenement.php', ['data'=>$data, 'errors'=>$errors]); ?>
    <button type="submit" class="btn btn-primary mb-4">Modifier</button>
</form>




<?php include('../Views/footer.php'); ?>