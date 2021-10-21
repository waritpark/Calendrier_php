<?php require('bdd.php'); ?>
<?php require('header.php'); ?>

    <div class="row text-center justify-content-center">
        <div class="col-6">
            <legendfield class="h2">Connexion</legendfield>
            <form action="login.php" method="post" class="mt-4">
            <div class="mb-3">
                <div><?php $errs ?></div>
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