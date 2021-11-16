<?php
    session_start();
    if($_SESSION['id_utilisateur']=="") {
        header('location:../../Forms/connexion.php');
    }
?> 

<?php  
require '../../App/bdd.php';
require '../../Calendar/Month.class.php';
require '../../Calendar/Events.class.php';
$pdo = get_pdo();
$events = new Calendrier\Events($pdo);
$month = new Calendrier\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getStartingDay();
$start = $start->format('N')=== '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 *($weeks -1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);
?>
<?php require '../../Views/includes/header.php'; ?>

        <?php if($_SESSION['role_user']== 2 || $_SESSION['role_user']== 1):  ?>
        <div class="mb-5 d-flex align-items-center justify-content-center">
                <a class="arrow-rotate180" href="dashboard.php?month=<?=$month->previousMonth()->month;?>&year=<?=$month->previousMonth()->year;?>">
                    <img src="../../Public/imgs/arrow.png" class="arrow-btn">
                </a>
                <h1 class="mx-5 w-300 d-flex justify-content-center"><?php echo $month->toString(); ?></h1>
                <a class="" href="dashboard.php?month=<?=$month->nextMonth()->month;?>&year=<?=$month->nextMonth()->year;?>">
                    <img src="../../Public/imgs/arrow.png" class="arrow-btn">
                </a>
        </div>  
        <!-- modal de sauvegarde success -->
        <?php  if (isset($_GET['success'])): ?>
            <div class="modal d-block" id="modal-success-event">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information :</h5>
                            <button onclick="removeSuccess();" type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Votre événement a été sauvegardé !</p>
                        </div>
                        <div class="modal-footer">
                            <button onclick="removeSuccess();" type="button" class="btn btn-prev-<?= $month->toStringMonth() ?>">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <!-- modal de modification success -->
        <?php  if (isset($_GET['modification'])): ?>
            <div class="modal d-block" id="modal-success-event">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information :</h5>
                            <button onclick="removeSuccess();" type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Votre événement a été modifié !</p>
                        </div>
                        <div class="modal-footer">
                            <button onclick="removeSuccess();" type="button" class="btn btn-prev-<?= $month->toStringMonth() ?>">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <!-- modal d'edit de compte success -->
        <?php  if (isset($_GET['edit'])): ?>
            <div class="modal d-block" id="modal-success-event">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information :</h5>
                            <button onclick="removeSuccess();" type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Les informations de votre compte ont été sauvegardé !</p>
                        </div>
                        <div class="modal-footer">
                            <button onclick="removeSuccess();" type="button" class="btn btn-prev-<?= $month->toStringMonth() ?>">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
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
                    $isToday = date('Y-m-d') === $date->format('Y-m-d'); ?>
                    <td class="w-14 align-top position-relative td-month-<?= $month->toStringMonth() ?> <?= $month->withinMonth($date) ? '' : 'bg-second'; ?><?= $isToday ? 'ajout-event-'.$month->toStringMonth().'' : ''; ?>">
                        <a class="position-absolute h-100 w-100 top-0 right-0" href="day-evenement.php?date=<?= $date->format('Y-m-d');?>"></a>
                    <?php $eventsForDay = $events[$date->format('Y-m-d')] ?? []; ?>
                        <div class="fs-5"><?= $date->format('d');?></div>
                        <?php foreach($eventsForDay as $event): ?>
                            <div class="container-calendar-event d-flex align-items-center fs-6">
                                <div><?= (new DateTimeImmutable($event['start_event']))->format('H:i'); ?>&nbsp;-&nbsp;</div>
                                <div><?php echo $event['nom_event'];?></div>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <?php endforeach; ?>
                    </tr>
                <?php } ?>
        </table>
        <!-- <a class="ajout-event ajout-event-<?php //$month->toStringMonth() ?> d-block position-absolute" href="../Views/ajout-evenement.php">
            <div class="position-relative img-ajout-event1"></div>
            <div class="position-relative img-ajout-event2"></div>
        </a> -->
        <?php endif; ?>

<?php include '../../Views/includes/footer.php'; ?>