<?php
session_start();
if($_SESSION['id_utilisateur']=="") {
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
$req1 ='SELECT * FROM t_utilisateur WHERE ID_utilisateur='.$_SESSION['id_utilisateur'].'';
$result=$pdo->query($req1);
while ($row=$result->fetch(PDO::FETCH_ASSOC)){ 
$id = $row['ID_utilisateur'];
?>
    <div class="mb-3">
        <label for="mail" class="form-label">Adresse mail</label>
        <input type="email" class="form-control" id="mail" name="mail" value="<?= $row['mail'] ?>">
    </div>
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo" value="<?= $row['pseudo'] ?>">
    </div>
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" id="nom" value="<?= $row['nom'] ?>">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" name="prenom" id="prenom" value="<?= $row['prenom'] ?>">
    </div>
    <?php } ?>
    <button type="submit" class="btn btn-primary mb-4">Modifier</button>
</form>

<?php 
if(isset($_POST['mail'])
    && isset($_POST['pseudo'])
    && isset($_POST['nom'])
    && isset($_POST['prenom'])) {
        $mail=$_POST['mail'];
        $pseudo=$_POST['pseudo'];
        $nom=$_POST['nom'];
        $prenom=$_POST['prenom'];
        $req2=$pdo->prepare('UPDATE t_utilisateur SET mail=:mail, pseudo=:pseudo, nom=:nom, prenom=:prenom WHERE ID_utilisateur='.$id.'');
        $req2->execute(array(
            'mail' => $mail,
            'pseudo' => $pseudo,
            'nom' => $nom,
            'prenom' => $prenom
        ));
        header('location:http://localhost/base-learn/Views/calendar/dashboard.php?edit=1');
    }
    ?>




<?php include('../../Views/includes/footer.php'); ?>