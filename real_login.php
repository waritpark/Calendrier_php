<?php 
session_start();
$_SESSION['connexion']=[];
include 'bdd.php';

if(isset($_POST['mail']) && isset($_POST['password']))  {
    if(!empty($_POST['mail'])) {
        if(!empty($_POST['password'])) {
            if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
                $mail = $_POST['mail'];
                $mdp = $_POST['password'];
                $req1= "SELECT * FROM t_utilisateur WHERE mail='$mail'";
                $result=$bdd->query($req1);
                $resultrow=$result->fetch(PDO::FETCH_ASSOC);
                if (password_verify($mdp, $resultrow['mdp'])) {
                    if($mail !="") {
                        $_SESSION['metier']=$resultrow['metier'];
                        $_SESSION['pseudo']=$resultrow['pseudo'];
                        $_SESSION['role']=$resultrow['role_id'];
                        header('Location:dashboard.php');
                    }
                    else {
                        array_push($_SESSION['connexion'],"L'adresse mail est invalide.");
                        header('Location:connexion.php');
                        session_destroy();
                    }
                }
                else {
                    array_push($_SESSION['connexion'],"Le mot de passe est incorrect.");
                    header("Location:connexion.php");
                }
            }
            else {
                array_push($_SESSION['connexion'],"L'adresse mail est incorrect.");
                header("Location:connexion.php");
            }
        }
        else {
            array_push($_SESSION['connexion'],"Veuillez entrer votre mot de passe.");
            header("Location:connexion.php");
        }
    }
    else {
        array_push($_SESSION['connexion'],"Veuillez entrer votre adresse mail.");
        header("Location:connexion.php");
    }
}
else {
    array_push($_SESSION['connexion'],"Un problème est survenue, veuillez réessayer.");
    header("Location:connexion.php");
}





?>