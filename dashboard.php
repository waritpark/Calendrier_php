<?php
    session_start();
    if($_SESSION['pseudo']=="") {
        header('location:connexion.php');
    }
?>

<?php include('header.php'); ?>
    <div class="container">

        <?php if($_SESSION['role']== 2):  ?>
        <?php echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un utilisateur.'; ?> <br>


        <?php elseif($_SESSION['role']== 1): ?>
        <?php echo 'Bonjour ' .$_SESSION['pseudo'].'. Vous êtes un admin.'; ?> <br>


        <?php else: ?>
        <?php echo 'Erreur inconnue.'; ?> <br>
        <?php echo var_dump($_SESSION['role']); ?>
        <?php endif;  ?>


    </div>
<?php include('footer.php'); ?>