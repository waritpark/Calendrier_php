<?php
session_start();
if($_SESSION['mail']=="") {
    header('location:../../Forms/connexion.php');
}

require '../../App/bdd.php';
require '../../Public/utility.php';
require '../../Calendar/Event.class.php';
require '../../Calendar/Events.class.php';
require '../../Calendar/Validator-event.class.php';
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
        $event->setIdUser($_SESSION['id_utilisateur'],PDO::PARAM_INT);
        debug($event);
        $events = new \Calendrier\Events(get_pdo());
        $events->create($event);
        header('Location:../calendar/dashboard.php?success=1');
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
$dt = DateTime::createFromFormat('d/m/Y', $date);
?>

<?php require '../../Views/includes/header.php'; ?>

<?php setlocale (LC_TIME, 'fr.utf8'); ?>
    <div class="col-12">
        <h2 class="w-max-content m-0 mb-4"><?= strftime('%A %d %B %Y', strtotime($date));?></h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-3" scope="col">Heures</th>
                    <th class="col-3" scope="col">Noms</th>
                    <th class="col-3" scope="col">Descriptions</th>
                    <th class="col-3" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php foreach($events as $event): ?>
                    <tr class="align-items-center fs-6">
                        <td><?= (new DateTimeImmutable($event['start_event']))->format('H:i'); ?></td>
                        <td><?php echo $event['nom_event']; ?></td>
                        <td><?php echo $event['desc_event'];?></td>
                        <td>
                            <a class="btn text-black btn-warning bg-gradient p-2" href="edit-evenement.php?id_event=<?php echo $event['id_event'];?>">Modifier</a>
                            <a class="btn text-white btn-danger bg-gradient p-2" href="delete-evenement.php?id_event=<?php echo $event['id_event'];?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <button type="button" class="btn btn-success" id="btn-afficher-form" onclick="afficherForm()">Ajouter un événement</button>
    </div>
    <div class="col-12 d-none mt-4" id="container-form-ajout-event">
        <h2>Ajout d'un nouvel événement</h2>
        <form action="#" method="post" class="mt-4 form-ajout-event">
            <?php render('../../Forms/form-evenement.php', ['data'=>$data, 'errors'=>$errors]); ?>
            <button type="submit" class="btn btn-primary mb-4">Ajouter</button>
        </form>
    </div>
</div>


<?php include('../../Views/includes/footer.php'); ?>