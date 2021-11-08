<?php 
session_start();
if($_SESSION['role']!=1){
    header('Location:http://localhost/base-learn/');
}
require '../../App/bdd.php';
require '../../Views/includes/header.php'; ?>


<table class="table table-striped align-middle" id="table-stats">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mail</th>
            <th>Pseudo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Role ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php $req1 = "SELECT ID_utilisateur, mail, pseudo, nom, prenom, role_id FROM t_utilisateur ORDER BY ID_utilisateur ASC";
    $result=$pdo->query($req1);
    while ($row=$result->fetch(PDO::FETCH_ASSOC)){ ?>
        <tr>
            <td><?= $row['ID_utilisateur']; ?></td>
            <td><?= $row['mail']; ?></td>
            <td><?= $row['pseudo']; ?></td>
            <td><?= $row['nom']; ?></td>
            <td><?= $row['prenom']; ?></td>
            <td><?= $row['role_id']; ?></td>
            <?php if($row['mail'] != 'arthur@arthur.fr'): ?>
                <td><a class="btn btn-warning" href="../users/edit-user.php?id_user=<?=$row['ID_utilisateur'];?>">Modifier</a></td>
                <td><a class="btn btn-danger" href="../users/supp-user.php?id_user=<?=$row['ID_utilisateur'];?>">Supprimer</a></td>
            <?php endif; ?>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php include '../../Views/includes/footer.php'; ?>


