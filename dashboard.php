<?php
    // session_start();
    // if($_SESSION['pseudo']=="") {
    //     header('location:connexion.php');
    // }
?>
<?php include_once 'month.php'; ?>  
<?php include_once 'header.php'; ?>
    <div class="container">

        <?php //if($_SESSION['role']== 2):  ?>
        <?php //echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un utilisateur.'; ?> <br>




        <?php //elseif($_SESSION['role']== 1): ?>
        <?php //echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un admin.'; ?> <br>

       <?php $month = new definitMonth\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
       $firstDay = $month->getStartingDay()->modify('last monday');
       ?>
        <div class="mb-5 d-flex align-items-center justify-content-center">
                <a class="btn btn-secondary" href="base-learn/dashboard.php?month=<?= $month->previousMonth()->month;?>&year=<?= $month->previousMonth()->year;?>">&lt;</a>
                <h1 class="mx-5"><?php echo $month->toString(); ?></h1>
                <a class="btn btn-secondary" href="base-learn/dashboard.php?month=<?= $month->nextMonth()->month;?>&year=<?= $month->nextMonth()->year;?>">&gt;</a>
        </div>  

        <table class="table table-bordered" id="calendar-table">
            <?php for($i = 0; $i < $month->getWeeks(); $i++) {  ?>
                <tr>
                <?php foreach($month->days as $s): ?>
                    <?php if($i === 0): ?>
                        <th class="text-center align-middle"><?= $s; ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tr>
                <tr>
                <?php foreach($month->days as $k => $day): 
                    $date=(clone $firstDay)->modify("+" . ($k + $i * 7). "days");?>
                    <td class="w-14 align-top fs-5 <?= $month->withinMonth($date) ? 'table-light' : 'table-secondary'; ?>">
                       <?= $date->format('d'); ?>
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