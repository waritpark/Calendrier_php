<?php
    session_start();
    if($_SESSION['pseudo']=="") {
        header('location:../Forms/connexion.php');
    }
?> 
<?php  
require '../App/bdd.php';
require '../Calendar/Month.class.php';
require '../Calendar/Events.class.php';
$pdo = get_pdo();
$events = new Calendrier\Events($pdo);
$month = new Calendrier\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();
$start = $start->format('N')=== '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 *($weeks -1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);
?>
<?php require '../Views/header.php'; ?>

        <?php //if($_SESSION['role']== 2):  ?>
        <?php //echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un utilisateur.'; ?> <br>


        <?php //elseif($_SESSION['role']== 1): ?>
        <?php //echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un admin.'; ?> <br>


        <div class="mb-5 d-flex align-items-center justify-content-center">
                <a class="btn btn-nav text-white btn-next-<?= $month->toStringMonth() ?>" href="dashboard.php?month=<?=$month->previousMonth()->month;?>&year=<?=$month->previousMonth()->year;?>">
                    <div class="position-relative arrow-left"></div>
                    <div class="position-relative arrow-right"></div>
                </a>
                <h1 class="mx-5 w-300 d-flex justify-content-center"><?php echo $month->toString(); ?></h1>
                <a class="btn btn-nav position-relative text-white btn-prev-<?= $month->toStringMonth() ?>" href="dashboard.php?month=<?=$month->nextMonth()->month;?>&year=<?=$month->nextMonth()->year;?>">
                    <span class="position-absolute arrow-rotate180">
                        <div class="position-relative arrow-left"></div>    
                        <div class="position-relative arrow-right"></div>
                    </span>
                </a>
        </div>  

        <table class="table table-bordered" id="calendar-table">
            <tr>
            <?php foreach($month->days as $s): ?>
                <th class="text-center align-middle border"><?php echo $s; ?></th>
            <?php endforeach; ?>
            </tr>
            <?php for($i = 0; $i < $weeks; $i++) {  ?>
                <tr>
                <?php 
                foreach($month->days as $k => $day): 
                    $date=$start->modify("+" . ($k + $i * 7). "days"); 
                    ?>
                    <td class="w-14 align-top td-month-<?= $month->toStringMonth() ?> <?= $month->withinMonth($date) ? '' : 'bg-second'; ?>">
                    <?php 
                    $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                    foreach($eventsForDay as $event): ?>
                        <a class="text-decoration-none text-black calendar-event <?= $month->withinMonth($date) ? '' : 'bg-second'; ?>" href="event.php?id_event=<?= $event['id_event'];?>">
                        <?php endforeach; ?>
                        <div class="fs-5"><?= $date->format('d');?></div>
                            <?php 
                            foreach($eventsForDay as $event): ?>
                                <div class="container-calendar-event d-flex align-items-center fs-6">
                                    <div><?= (new DateTimeImmutable($event['start_event']))->format('H:i'); ?>&nbsp;-&nbsp;</div>
                                    <div class="calendar-event" href="event.php?id=<?= $event['id_event'];?>"><?= $event['nom_event']; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </a>
                    </td>
                <?php endforeach; ?>
                </tr>
            <?php } ?>
        </table>
        <a class="ajout-event ajout-event-<?= $month->toStringMonth() ?> d-block position-absolute" href="../Forms/ajout-evenement.php">
            <div class="position-relative img-ajout-event1"></div>
            <div class="position-relative img-ajout-event2"></div>
        </a>

        <?php //else: ?>
        <?php //echo 'Erreur inconnue.'; ?> <br>
        <?php //echo var_dump($_SESSION['role']); ?>
        <?php //endif;  ?>


<?php include '../Views/footer.php'; ?>