<?php
require('bdd.php');
session_start();
$_SESSION['inscription']=[];

$mail = valid_donnees($_POST["mail"]);
$password = valid_donnees($_POST["password"]);

function valid_donnees($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

$pass_hash=password_hash($_POST["password"], PASSWORD_DEFAULT);


if (isset($_POST["mail"]) 
    && isset($_POST["password"]) 
    && !empty($_POST["mail"]) 
    && !empty($_POST["password"]) 
    && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)
    && $_POST["password"]===$_POST["password2"]) {
    $req1 = $pdo->prepare("SELECT mail FROM t_utilisateur WHERE mail=?");
    $req1->execute([$mail]); 
    $user = $req1->fetch();
    if ($user) {
        array_push($_SESSION['inscription'],"Ce mail est deja pris !");
        header("Location:../Forms/inscription.php");
    }
    else {
        try {
            $req = $pdo->prepare("INSERT INTO t_utilisateur (mail, mdp, role_user) VALUES (:mail, :mdp, 2)");
            $req->execute(array(
                "mail" => $mail,
                "mdp" => $pass_hash
                ));
            $req->fetch(PDO::FETCH_ASSOC);
            header('Location: ../Forms/connexion.php');
        }
        catch(PDOException $e) {
            echo 'Erreur : '.$e->getMessage();
        }
    }
}
else {
    array_push($_SESSION['inscription'],"Erreur dans la grosse condition.");
    header("Location: ../Forms/inscription.php");
}


?>