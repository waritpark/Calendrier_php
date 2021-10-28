<?php
require '../App/bdd.php';
require '../Public/utility.php';
require '../Calendar/Event.class.php';
require '../Calendar/Events.class.php';
require '../Calendar/Validator-event.class.php';
session_start();
if($_SESSION['pseudo']=="") {
    header('location:../Forms/connexion.php');
}
?>
<?php 
$data = [];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendrier\ValidatorEvent();
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
<?php require '../Views/header.php'; ?>

<legendfield class="h2">Ajout d'un nouvel événement</legendfield>
<form action="#" method="post" class="mt-4 form-ajout-event">
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= isset($data['nom']) ? h($data['nom']) : ''; ?>">
        <?php if (isset($errors['nom'])): ?>
        <p class="alert alert-danger"><?= $errors['nom']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <textarea type="text" class="form-control" name="desc" id="desc"><?= isset($data['desc']) ? h($data['desc']) : ''; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" name="date" id="date" value ="<?= isset($data['date']) ? h($data['date']) : ''; ?>">
        <?php if (isset($errors['date'])): ?>
        <p class="alert alert-danger"><?= $errors['date']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="start" class="form-label">Début de l'événement</label>
        <input type="time" class="form-control" name="start" id="start" value="<?= isset($data['start']) ? h($data['start']) : ''; ?>">
        <?php if (isset($errors['start'])): ?>
        <p class="alert alert-danger"><?= $errors['start']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="end" class="form-label">fin de l'événement</label>
        <input type="time" class="form-control" name="end" id="end" value="<?= isset($data['end']) ? h($data['end']) : ''; ?>">
        <?php if (isset($errors['time'])): ?>
        <p class="alert alert-danger"><?= $errors['time']; ?></p>
        <?php endif;?>
    </div>
    <button type="submit" class="btn btn-primary mb-4">Ajouter</button>
</form>




<?php include('../Views/footer.php'); ?>