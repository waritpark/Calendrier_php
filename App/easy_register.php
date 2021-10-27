<?php
require('bdd.php');
session_start();
$_SESSION['inscription']=[];

$mail = valid_donnees($_POST["mail"]);
$pseudo = valid_donnees($_POST["pseudo"]);
$password = valid_donnees($_POST["password"]);

function valid_donnees($donnees){
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

$pass_hash=password_hash($_POST["password"], PASSWORD_DEFAULT);


if (isset($_POST["mail"]) 
    && isset($_POST["pseudo"]) 
    && isset($_POST["password"]) 
    && !empty($_POST["mail"]) 
    && !empty($_POST["pseudo"]) 
    && !empty($_POST["password"]) 
    && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)
    && $_POST["password"]===$_POST["password2"]) {
    $req1 = $pdo->prepare("SELECT pseudo FROM t_utilisateur WHERE pseudo=?");
    $req1->execute([$pseudo]); 
    $user = $req1->fetch();
    if ($user) {
        array_push($_SESSION['inscription'],"Ce pseudo est deja pris !");
        header("Location:inscription.php");
    }
    else {
        try {
            $req = $pdo->prepare("INSERT INTO t_utilisateur (mail, pseudo, mdp, role_id) VALUES (:mail, :pseudo, :mdp, 2)");
            $req->fetch(PDO::FETCH_ASSOC);
            $req->execute(array(
                "mail" => $mail,
                "pseudo" => $pseudo,
                "mdp" => $pass_hash
                ));
            header('Location: ../Forms/connexion.php');
        }
        catch(PDOException $e) {
            echo 'Erreur : '.$e->getMessage();
        }
    }
}
else {
    array_push($_SESSION['inscription'],"Erreur dans la grosse condition.");
    header("Location: inscription.php");
}


?>