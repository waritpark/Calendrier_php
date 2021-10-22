<?php 
session_start();

    include 'bdd.php';

        if(isset($_POST['pseudo']) 
        && isset($_POST['password']) 
        && !empty($_POST['pseudo']) 
        && !empty($_POST['password'])) {
            if ($_POST['pseudo']!="" && $_POST['password']!=""){
                $pseudo = $_POST['pseudo'];
                $mdp = $_POST['password'];
                $req1= "SELECT * FROM t_utilisateur WHERE pseudo='$pseudo'";
                $result=$bdd->query($req1);
                $resultrow=$result->fetch(PDO::FETCH_ASSOC);
                // var_dump($resultrow);
                if (password_verify($mdp, $resultrow['mdp'])) {
                    if($pseudo!="") {
                        $_SESSION['pseudo']=$pseudo;
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