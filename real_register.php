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

if (isset($_POST["mail"])) {
    if (isset($_POST["pseudo"])) {
        if (isset($_POST["password"])) {
            if (isset($_POST["password2"])) {
                if (!empty($_POST["mail"])) {
                    if(!empty($_POST["pseudo"])) {
                        if(!empty($_POST["password"])) {
                            if (!empty($_POST["password2"])) {
                                if (strlen($_POST["mail"])<=10 || strlen($_POST["mail"])>200) {
                                    array_push($_SESSION['inscription'],"L'adresse mail ne correspond pas à nos attentes. ");
                                    header("Location:inscription.php");
                                }
                                else {
                                    if(strlen($_POST["pseudo"])< 6 || strlen($_POST["pseudo"])>50) {
                                        array_push($_SESSION['inscription'],"Le Pseudo doit contenir au minimum 6 caractères.");
                                        header("Location:inscription.php");
                                    }
                                    else {
                                        if(strlen($_POST["password"])< 8 || strlen($_POST["password"])>255) {
                                            array_push($_SESSION['inscription'],"Le mot de passe doit contenir minimum 8 caractères.");
                                            header("Location:inscription.php");
                                        }
                                        else {
                                            if ($_POST["password"]!==$_POST["password2"]) {
                                                array_push($_SESSION['inscription'],"Les mots de passe ne sont pas identiques.");
                                            header("Location:inscription.php");

                                            }
                                            else {
                                                if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
                                                    $req1 = $bdd->prepare("SELECT pseudo FROM t_utilisateur WHERE pseudo=?");
                                                    $req1->execute([$pseudo]); 
                                                    $user = $req1->fetch();
                                                    if ($user) {
                                                        array_push($_SESSION['inscription'],"Ce Pseudo est deja pris !");
                                                        header("Location:inscription.php");
                                                    }
                                                    else {
                                                        try {
                                                            $req = $bdd->prepare("INSERT INTO t_utilisateur (mail, pseudo, mdp, role_id) VALUES (:mail, :pseudo, :mdp, 2)");
                                                            $req->fetch(PDO::FETCH_ASSOC);
                                                            $req->execute(array(
                                                                "mail" => $mail,
                                                                "pseudo" => $pseudo,
                                                                "mdp" => $pass_hash
                                                                ));
                                                            header('Location: connexion.php');
                                                        }
                                                        catch(PDOException $e) {
                                                            echo 'Erreur : '.$e->getMessage();
                                                        }
                                                    }
                                                } 
                                                else {
                                                    array_push($_SESSION['inscription'],"L'adresse mail est invalide.");
                                                    header("Location:inscription.php");
                                                }  
                                            }
                                        }
                                    }
                                }
                            }
                            else {
                                array_push($_SESSION['inscription'],"Le champs 'Répetez le mot de passe' est obligatoire");
                            header("Location:inscription.php");

                            }
                        }
                        else {
                            array_push($_SESSION['inscription'],"Le champs 'Mot de passe' est obligatoire !");
                            header("Location:inscription.php");
                        }  
                    }
                    else {
                        array_push($_SESSION['inscription'],"Le champs 'Pseudo' est obligatoire !");
                        header("Location:inscription.php");
                    }  
                }
                else {
                    array_push($_SESSION['inscription'],"Le champs 'Mail' est obligatoire !");
                    header("Location:inscription.php");
                }
            }
            else {
                array_push($_SESSION['inscription'],"L'input 'Répetez le mot de passe' n'existe pas, veuillez recharger la page. ");
                header("Location:inscription.php");
            }     
        }
        else {
            array_push($_SESSION['inscription'],"L'input 'Mot de passe' n'existe pas, veuillez recharger la page.");
            header("Location:inscription.php");
        } 
    }
    else {
        array_push($_SESSION['inscription'],"L'input 'Pseudo' n'existe pas, veuillez recharger la page. ");
        header("Location:inscription.php");
    }
} 
else {
    array_push($_SESSION['inscription'],"L'input 'Mail' n'existe pas, veuillez recharger la page.");
    header("Location:inscription.php");
}

?>


