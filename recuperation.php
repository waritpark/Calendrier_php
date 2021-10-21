<?php session_start(); ?>
<?php require('bdd.php'); ?>
<?php require('header.php'); ?>

    <div class="row text-center justify-content-center">
        <div class="col-6">
            <?php if (!empty($_SESSION['recuperation'])) {
                foreach ($_SESSION['recuperation'] as $error) {?>
                <div class="text-danger"><?php echo $error[0]; ?></div>
                <div class="text-success"><?php echo $error[1]; ?></div>
            <?php }
            }; ?>
            <legendfield class="h2">Modifier le mot passe</legendfield>
            <form action="change_password.php" method="post" class="mt-4">
            <div class="mb-3">
                <div><?php $errs ?></div>
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo">
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Mail</label>
                <input type="mail" class="form-control" id="mail" name="mail">
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

<?php require('footer.php'); ?>

<?php unset($_SESSION['recuperation']) ?>