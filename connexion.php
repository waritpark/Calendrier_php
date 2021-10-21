<?php session_start(); ?>
<?php require('bdd.php'); ?>
<?php require('header.php'); ?>

    <div class="row text-center justify-content-center">
        <div class="col-6">
            <?php if (!empty($_SESSION['changermdp'])) {
                foreach ($_SESSION['changermdp'] as $error) {?>
                <div class="text-danger"><?php echo $error[0]; ?></div>
                <div class="text-success"><?php echo $error[1]; ?></div>
            <?php }
            }; ?>
            <legendfield class="h2">Connexion</legendfield>
            <form action="login.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary w-auto">Connexion</button>
            <a href="recuperation.php" class="w-auto">Mot de passe oublié ?</a>
            </div>
            </form>
        </div>
    </div>

<?php require('footer.php'); ?>

<?php unset($_SESSION['changermdp']) ?>