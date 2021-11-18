<?php session_start(); ?>
<?php require('../App/bdd.php'); ?>
<?php require('../Views/includes/header.php'); ?>

    <div class="row text-center justify-content-center">
        <div class="col-6">
            <?php if (!empty($_SESSION['recuperation'])) {
                foreach ($_SESSION['recuperation'] as $error) {?>
                <div class="text-danger"><?php echo $error[0]; ?></div>
                <div class="text-success"><?php echo $error[1]; ?></div>
            <?php }
            }; ?>
            <h2>Modifier le mot passe</h2>
            <form action="../App/test_mail.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="mail" class="form-control" id="mail" name="mail">
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

<?php require('../Views/includes/footer.php'); ?>

<?php unset($_SESSION['recuperation']) ?>