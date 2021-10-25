<?php 
session_start();

include 'bdd.php';

if(isset($_POST['mail']) 
&& isset($_POST['password']) 
&& !empty($_POST['mail']) 
&& !empty($_POST['password'])) {
    if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
        $mail = $_POST['mail'];
        $mdp = $_POST['password'];
        $req1= "SELECT * FROM t_utilisateur WHERE mail='$mail'";
        $result=$pdo->query($req1);
        $resultrow=$result->fetch(PDO::FETCH_ASSOC);
        if (password_verify($mdp, $resultrow['mdp'])) {
            if($mail!="") {
                $_SESSION['metier']=$resultrow['metier'];
                $_SESSION['pseudo']=$resultrow['pseudo'];
                $_SESSION['role']=$resultrow['role_id'];
                header('Location:dashboard.php');
            }
            else {
                header('Location:connexion.php');
                session_destroy();
            }
        }
        else {
            header('Location:connexion.php');

        }
    }
    else {
        header('Location:connexion.php');
    }
}
else {
    header('Location:connexion.php');
}





?>