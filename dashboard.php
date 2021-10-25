<?php
    // session_start();
    // if($_SESSION['pseudo']=="") {
    //     header('location:connexion.php');
    // }
?> 
<?php  
require 'bdd.php';
require 'month.php';
require 'events.php';
$pdo = get_pdo();
$events = new Calendrier\Events($pdo);
$month = new Calendrier\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();
$start = $start->format('N')=== '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 *($weeks -1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);
?>
<?php require 'header.php'; ?>
    <div class="container">

        <?php //if($_SESSION['role']== 2):  ?>
        <?php //echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un utilisateur.'; ?> <br>


        <?php //elseif($_SESSION['role']== 1): ?>
        <?php //echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un admin.'; ?> <br>


        <div class="mb-5 d-flex align-items-center justify-content-center">
                <a class="btn btn-secondary" href="dashboard.php?month=<?=$month->previousMonth()->month;?>&year=<?=$month->previousMonth()->year;?>">&lt;</a>
                <h1 class="mx-5 w-300 d-flex justify-content-center"><?php echo $month->toString(); ?></h1>
                <a class="btn btn-secondary" href="dashboard.php?month=<?=$month->nextMonth()->month;?>&year=<?=$month->nextMonth()->year;?>">&gt;</a>
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
                    <td class="w-14 align-top td-month-<?= $month->toStringMonth() ?> <?= $month->withinMonth($date) ? 'text-black' : 'text-second'; ?>">
                        <a class="text-decoration-none text-black calendar-event" href="event.php?id=<?= $event['id_event'];?>">
                            <div class="fs-5"><?= $date->format('d');?></div>
                            <?php 
                            $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                            foreach($eventsForDay as $event): ?>
                                <div class="container-calendar-event">
                                    <?= (new DateTimeImmutable($event['start_event']))->format('H:i'); ?> 
                                    - <a class="calendar-event" href="event.php?id=<?= $event['id_event'];?>"><?= $event['nom_event']; ?></a>
                                </div>
                            <?php endforeach; ?>
                        </a>
                    </td>
                <?php endforeach; ?>
                </tr>
            <?php } ?>
        </table>


        <?php //else: ?>
        <?php //echo 'Erreur inconnue.'; ?> <br>
        <?php //echo var_dump($_SESSION['role']); ?>
        <?php //endif;  ?>


    </div>
<?php include('footer.php'); ?>