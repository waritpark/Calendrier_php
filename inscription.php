<?php session_start(); ?>
<?php require('bdd.php'); ?>
<?php require('header.php'); ?>



    <div class="row text-center justify-content-center">
        <div class="col-6">
        
            <?php if (!empty($_SESSION['inscription'])) {
                foreach ($_SESSION['inscription'] as $error) {?>
                <div class="text-danger"><?php echo $error; ?></div>
            <?php }
            }; ?>
            <legendfield class="h2">Inscription</legendfield>
            <form action="easy_register.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="mail" class="form-label">Adresse mail</label>
                <input type="email" class="form-control" id="mail" name="mail" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo">
                <div class="fw-lighter">Votre pseudo doit contenir au minimum 6 caractères.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="alert alert-secondary" id="passwordStrength">Jauge de fiabilité du mot de passe</div>
            <div class="mb-3">
                <label for="password2" class="form-label">Répétez le mot de passe</label>
                <input type="password" class="form-control" name="password2" id="password2">
            </div>
            <div id="egal"></div>
            <button type="submit" class="btn btn-primary">Inscription</button>
            </form>
        </div>
    </div>

<?php require('footer.php'); ?>

<?php unset($_SESSION['inscription']) ?>