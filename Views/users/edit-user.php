<?php
session_start();
if($_SESSION['role_user']!=1) {
    header('location:../../Forms/connexion.php');
}

require '../../App/bdd.php';
require '../../Public/utility.php';
require '../../Calendar/Event.class.php';
require '../../Calendar/Events.class.php';
require '../../Calendar/Validator-event.class.php';

$pdo = get_pdo();
$events = new Calendrier\Events($pdo);


?>


<?php require '../../Views/includes/header.php'; ?>

<legendfield class="h2">Modifier les informations</legendfield>
<form action="" method="post" class="mt-4 form-ajout-event">
<?php 
$req1 ='SELECT * FROM t_utilisateur WHERE ID_utilisateur='.$_GET['id_user'].'';
$result=$pdo->query($req1);
while ($row=$result->fetch(PDO::FETCH_ASSOC)){ 
$id =$row['ID_utilisateur'];
?>
    <div class="mb-3">
        <label for="mail" class="form-label">Adresse mail</label>
        <input type="email" class="form-control" id="mail" name="mail" value="<?= $row['mail'] ?>">
    </div>
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" id="nom" value="<?= $row['nom'] ?>">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" name="prenom" id="prenom" value="<?= $row['prenom'] ?>">
    </div>
    <div class="mb-3">
        <label for="role_user" class="form-label">Role id</label>
        <input type="number" class="form-control" id="role_user" name="role_user" value="<?= $row['role_user'] ?>">
    </div>
    <?php } ?>
    <button type="submit" class="btn btn-primary mb-4">Modifier</button>
</form>
<?php 
if(isset($_POST['mail'])
    && isset($_POST['nom'])
    && isset($_POST['prenom'])
    && isset($_POST['role_user'])) {
        $mail=$_POST['mail'];
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $role_user=$_POST['role_user'];
        $req2=$pdo->prepare('UPDATE t_utilisateur SET mail=:mail, nom=:nom, prenom=:prenom, role_user=:role_user WHERE ID_utilisateur='.$id.'');
        $req2->execute(array(
            'mail' => $mail,
            'nom' => $nom,
            'prenom' => $prenom,
            'role_user' => $role_user,
        ));
        header('location:http://localhost/base-learn/Views/calendar/stats.php?edit=1');
    }
    ?>




<?php include('../../Views/includes/footer.php'); ?>