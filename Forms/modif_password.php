<?php session_start();
    if(empty($_SESSION['mail_change'])){
        header('location:../index.php');
    } ?>
<?php require('../App/bdd.php'); ?>
<?php require('../Views/includes/header.php'); ?>

    <div class="row text-center justify-content-center">
        <div class="col-6">
        <?php if (!empty($_SESSION['changermdp'])) {
                foreach ($_SESSION['changermdp'] as $error) {?>
                <div class="text-danger"><?php echo $error[0]; ?></div>
                <div class="text-success"><?php echo $error[1]; ?></div>
            <?php }
            }; ?>
            <legendfield class="h2">Modification du mot de passe</legendfield>
            <form action="../App/password_change.php" method="post" class="mt-4">
            <div class="mb-3">
                <input type="mail" disabled hidden class="form-control" id="mail" name="mail" value="<?php $_GET['mail'] ?>">
            </div>
            <div class="mb-3">
                <label for="token" class="form-label">Mot de passe attribué provisoirement :</label>
                <input type="text" disabled hidden class="form-control" id="token" name="token" value="<?php $_GET['token'] ?>">
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Noveau mot de passe</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="mb-3">
                <label for="repeat_password" class="form-label">Répétez le mot de passe</label>
                <input type="password" class="form-control" id="repeat_password" name="repeat_password">
            </div>
            <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary w-auto">Changer de mot de passe</button>
            </div>
            </form>
        </div>
    </div>

<?php require('../Views/includes/footer.php'); ?>

<?php unset($_SESSION['recuperation']) ?>