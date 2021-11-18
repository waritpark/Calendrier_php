<?php

namespace App\Controllers;

use PDO;
use PDOException;
use App\Controllers\BddController;

class UtilisateursController 
{

    public function real_login()
    {
        if(isset($_POST['mail']) && isset($_POST['password']))  {
            if(!empty($_POST['mail'])) {
                if(!empty($_POST['password'])) {
                    if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
                        $mail = $_POST['mail'];
                        $mdp = $_POST['password'];
                        $req1= "SELECT * FROM t_utilisateur WHERE mail='$mail'";
                        $result=get_pdo()->query($req1);
                        $resultrow=$result->fetch(PDO::FETCH_ASSOC);
                        if (password_verify($mdp, $resultrow['mdp'])) {
                            if($mail !="") {
                                $_SESSION['role_user']=$resultrow['role_user'];
                                $_SESSION['mail']=$resultrow['mail'];
                                header('Location:../Views/calendar/dashboard.php');
                            }
                            else {
                                array_push($_SESSION['connexion'],"L'adresse mail est invalide.");
                                header('Location:../Forms/connexion.php');
                                session_destroy();
                            }
                        }
                        else {
                            array_push($_SESSION['connexion'],"Le mot de passe est incorrect.");
                            header("Location:../Forms/connexion.php");
                        }
                    }
                    else {
                        array_push($_SESSION['connexion'],"L'adresse mail est incorrect.");
                        header("Location:../Forms/connexion.php");
                    }
                }
                else {
                    array_push($_SESSION['connexion'],"Veuillez entrer votre mot de passe.");
                    header("Location:../Forms/connexion.php");
                }
            }
            else {
                array_push($_SESSION['connexion'],"Veuillez entrer votre adresse mail.");
                header("Location:../Forms/connexion.php");
            }
        }
        else {
            array_push($_SESSION['connexion'],"Un problème est survenue, veuillez réessayer.");
            header("Location:../Forms/connexion.php");
        }
    }

    public function real_mail() {
        if( isset($_POST['mail']) 
        && !empty($_POST['mail'])
        && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
            $mail=$_POST['mail'];
            $req1=get_pdo()->prepare("SELECT * FROM t_utilisateur WHERE mail= ?");
            $req1->execute([$mail]);
            $resultrow=$req1->fetch(PDO::FETCH_ASSOC);
            if ($resultrow) {
                $string = implode('', array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9')));
                $token = substr(str_shuffle($string), 0, 20);
                $_SESSION['mail_change'] = $token;

                $mail_recup_exist = get_pdo()->prepare("SELECT ID_recup FROM t_recuperation WHERE mail_recup=?");
                // $mail_recup_exist->execute(array($recup_mail));
                $mail_recup_exist=$mail_recup_exist->rowCount();
                if ($mail_recup_exist==1) {
                    $req2=get_pdo()->prepare("UPDATE t_recuperation SET token_recup=? WHERE mail_recup=?");
                    $req2->execute([$token, $_POST["mail"]]);
                } else {
                    $req2=get_pdo()->prepare("INSERT INTO t_recuperation(mail_recup,token_recup) VALUES (?, ?)");
                    $req2->execute([$token, $_POST["mail"]]);
                };
                // variables du mail
                $link = "http://localhost/base-learn/modif_password?token='.$token.'?mail='.$mail.'";
                $objet = 'Nouveau mot de passe';
                $to = 'lafarge21@hotmail.fr';
                $headers =["From: Support :<zzzzzzz@zzzz.zz>","MIME-version: 1.0","Content-type: text/html; charset=utf-8","Content-Transfer-Encoding: 8bit"];
                $message = "<html>".
                "<body>".
                "<p>Veuillez cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe et en recevoir un nouveau.</p>".
                "<a href=".$link." style='font-size: 18px'>Cliquez ici</a>".
                "</body>".
                "</html>";

                //===== Envoi du mail
                $success=mail($to, $objet, $message,implode("\r\n", $headers));
                if (!$success) {
                    $error_message = error_get_last()['message'];
                    // array_push($_SESSION['recuperation'],["Echec de l'envoie.", ""]);
                    // header("Location:recuperation.php");
                }
                else{
                    array_push($_SESSION['recuperation'],["","Un mail a été envoyé à votre adresse mail."]);
                    header("Location:../Forms/recuperation.php");
                }
            }
            else {
                array_push($_SESSION['recuperation'],["Votre mail est incorrect.", ""]);
                header("Location:../Forms/recuperation.php");
            }
        }
    }

    public function real_register()
    {
        $mail = valid_donnees($_POST["mail"]);
        $password = valid_donnees($_POST["password"]);
        $nom = valid_donnees($_POST["password"]);
        $prenom = valid_donnees($_POST["password"]);


        function valid_donnees($donnees){
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }

        $pass_hash=password_hash($_POST["password"], PASSWORD_DEFAULT);

        if (isset($_POST["mail"]) 
        && isset($_POST["nom"]) 
        && isset($_POST["prenom"]) 
        && isset($_POST["password"]) 
        && isset($_POST["password2"])){
            if (!empty($_POST["mail"])) {
                if(!empty($_POST["nom"])) {
                    if(!empty($_POST["prenom"])) {
                        if(!empty($_POST["password"])) {
                            if (!empty($_POST["password2"])) {
                                if (strlen($_POST["mail"])<=10 || strlen($_POST["mail"])>200) {
                                    array_push($_SESSION['inscription'],"L'adresse mail ne correspond pas à nos attentes.");
                                    header("Location:../Forms/inscription.php");
                                }
                                else {
                                    if(strlen($_POST["password"])< 8 || strlen($_POST["password"])>255) {
                                        array_push($_SESSION['inscription'],"Le mot de passe doit contenir minimum 8 caractères.");
                                        header("Location:../Forms/inscription.php");
                                    }
                                    else {
                                        if(strlen($_POST["nom"])>255) {
                                            array_push($_SESSION['inscription'],"Le nom est trop long.");
                                            header("Location:../Forms/inscription.php");
                                        }
                                        else {
                                            if(strlen($_POST["prenom"])>255) {
                                                array_push($_SESSION['inscription'],"Le prénom est trop long.");
                                                header("Location:../Forms/inscription.php");
                                            }
                                            else {
                                                if ($_POST["password"]!==$_POST["password2"]) {
                                                    array_push($_SESSION['inscription'],"Les mots de passe ne sont pas identiques.");
                                                header("Location:../Forms/inscription.php");

                                                }
                                                else {
                                                    if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
                                                        $req1 = get_pdo()->prepare("SELECT mail FROM t_utilisateur WHERE mail=?");
                                                        $req1->execute([$mail]); 
                                                        $user = $req1->fetch();
                                                        if ($user) {
                                                            array_push($_SESSION['inscription'],"Ce mail est deja pris !");
                                                            header("Location:../Forms/inscription.php");
                                                        }
                                                        else {
                                                            try {
                                                                $req = get_pdo()->prepare("INSERT INTO t_utilisateur (mail, nom, prenom, mdp, role_user) VALUES (:mail, nom:, prenom:, :mdp, 2)");
                                                                $req->fetch(PDO::FETCH_ASSOC);
                                                                $req->execute(array(
                                                                    "mail" => $mail,
                                                                    "nom" => $nom,
                                                                    "prenom" => $prenom,
                                                                    "mdp" => $pass_hash
                                                                    ));
                                                                header('Location:../Forms/connexion.php');
                                                            }
                                                            catch(PDOException $e) {
                                                                echo 'Erreur : '.$e->getMessage();
                                                            }
                                                        }
                                                    } 
                                                    else {
                                                        array_push($_SESSION['inscription'],"L'adresse mail est invalide.");
                                                        header("Location:../Forms/inscription.php");
                                                    }  
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            else {
                                array_push($_SESSION['inscription'],"Le champs 'Répetez le mot de passe' est obligatoire.");
                                header("Location:../Forms/inscription.php");
                            }
                        }
                        else {
                            array_push($_SESSION['inscription'],"Le champs 'Mot de passe' est obligatoire !");
                            header("Location:../Forms/inscription.php");
                        }
                    }
                    else {
                        array_push($_SESSION['inscription'],"Le champs 'Prénom' est obligatoire !");
                        header("Location:../Forms/inscription.php");
                    } 
                }
                else {
                    array_push($_SESSION['inscription'],"Le champs 'Mail' est obligatoire !");
                    header("Location:../Forms/inscription.php");
                }
            }
            else {
                array_push($_SESSION['inscription'],"Le champs 'Nom' est obligatoire !");
                header("Location:../Forms/inscription.php");
            }
        }
        else {
            array_push($_SESSION['inscription'],"Une erreur est survenue, veuillez recharger la page.");
            header("Location:../Forms/inscription.php");
        }
    }

    public function password_change()
    {
        if(isset($_POST['token'])
        && isset($_POST['mail'])  
        && isset($_POST['new_password']) 
        && isset($_POST['repeat_password']) 
        && !empty($_POST['token'])
        && !empty($_POST['mail'])  
        && !empty($_POST['new_password']) 
        && !empty($_POST['repeat_password']) 
        && $_POST['new_password']===$_POST['repeat_password']){
            $mail=$_POST['mail']; 
            $token=$_POST['token'];
            $verif_token=get_pdo()->prepare("SELECT * FROM t_recuperation WHERE token_recup=?");
            $verif_token->execute([$token]);
            $resultrow=$verif_token->fetch(PDO::FETCH_ASSOC);
            if ($resultrow) {
                $newMdp=password_hash($_POST["new_password"], PASSWORD_DEFAULT);
                $req2=get_pdo()->prepare("UPDATE t_utilisateur SET mdp =? WHERE mail=$mail");
                $req2->execute([$newMdp]);

                array_push($_SESSION['changermdp'],["", "Vous avez changé de mot de passe !"]);
                header("Location:../Forms/connexion.php");
            } else {
                array_push($_SESSION['changermdp'],["Mauvais token !", ""]);
                header("Location:../Forms/connexion.php");

            }
        }
        else {
            array_push($_SESSION['changermdp'],["Erreur.", ""]);
            header("Refresh: 2");
        }
    }

    public function destroy_session()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location:http://localhost/base-learn/");
        exit();
    }
}
