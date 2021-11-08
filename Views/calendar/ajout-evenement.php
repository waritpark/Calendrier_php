<?php
session_start();
if($_SESSION['pseudo']=="") {
    header('location:../../Forms/connexion.php');
}

require '../../App/bdd.php';
require '../../Public/utility.php';
require '../../Calendar/Event.class.php';
require '../../Calendar/Events.class.php';
require '../../Calendar/Validator-event.class.php';

?>
<?php 
$errors = [];
$data = [];
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
        $event->setIdUser($_SESSION['id_utilisateur'],PDO::PARAM_INT);
        debug($event);
        $events = new \Calendrier\Events(get_pdo());
        $events->create($event);
        header('Location:../../Views/calendar/dashboard.php?success=1');
        exit();
    }
}
?>
<?php require '../../Views/includes/header.php'; ?>

<legendfield class="h2">Ajout d'un nouvel événement</legendfield>
<form action="#" method="post" class="mt-4 form-ajout-event">
    <?php render('../../Forms/form-evenement.php', ['data'=>$data, 'errors'=>$errors]); ?>
    <button type="submit" class="btn btn-primary mb-4">Ajouter</button>
</form>




<?php include('../../Views/includes/footer.php'); ?>