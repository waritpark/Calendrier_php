<?php

namespace App\Controllers;

use PDO;
use PDOException;
use App\Controllers\BddController;

class UtilisateurController 
{

    public function easyLogin() 
    {
        if(isset($_POST['mail']) 
        && isset($_POST['password']) 
        && !empty($_POST['mail']) 
        && !empty($_POST['password'])) {
            if (filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
                $mail = $_POST['mail'];
                $mdp = $_POST['password'];
                $req1= "SELECT * FROM t_utilisateur WHERE mail='$mail'";
                $result=get_pdo()->query($req1);
                $resultrow=$result->fetch(PDO::FETCH_ASSOC);
                if (password_verify($mdp, $resultrow['mdp'])) {
                    if($mail!="") {
                        $_SESSION['id_utilisateur']=$resultrow['ID_utilisateur'];
                        $_SESSION['role_user']=$resultrow['role_user'];
                        $_SESSION['mail']=$resultrow['mail'];
                        header('Location:../Views/calendar/dashboard.php');
                    }
                    else {
                        header('Location:../Forms/connexion.php');
                        session_destroy();
                    }
                }
                else {
                    header('Location:../Forms/connexion.php');
        
                }
            }
            else {
                header('Location:../Forms/connexion.php');
            }
        }
        else {
            header('Location:../Forms/connexion.php');
        }  
    }

    public function easy_mail() 
    {
        $string = implode('', array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9')));
        $token = substr(str_shuffle($string), 0, 20);

        // variables du mail
        $link = "http://localhost/base-learn?token='.$token.'";
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
        $success = mail($to, $objet, $message,implode("\r\n", $headers));
        if (!$success) {
            $errorMessage = error_get_last()['message'];
        }else{
            $_SESSION['mail_change'] = $token;
            array_push($_SESSION['recuperation'],["","Un mail a été envoyé à votre adresse mail."]);
            header("Location:recuperation.php");
        }
    }

    public function easy_register()
    {
        $mail = valid_donnees($_POST["mail"]);
        $password = valid_donnees($_POST["password"]);

        function valid_donnees($donnees){
            $donnees = trim($donnees);
            $donnees = stripslashes($donnees);
            $donnees = htmlspecialchars($donnees);
            return $donnees;
        }

        $pass_hash=password_hash($password, PASSWORD_DEFAULT);

        if (isset($_POST["mail"]) 
            && isset($_POST["password"]) 
            && !empty($_POST["mail"]) 
            && !empty($_POST["password"]) 
            && filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)
            && $_POST["password"]===$_POST["password2"]) {
            $req1 = get_pdo()->prepare("SELECT mail FROM t_utilisateur WHERE mail=?");
            $req1->execute([$mail]); 
            $user = $req1->fetch();
            if ($user) {
                array_push($_SESSION['inscription'],"Ce mail est deja pris !");
                header("Location:inscription.php");
            }
            else {
                try {
                    $req = get_pdo()->prepare("INSERT INTO t_utilisateur (mail, mdp, role_user) VALUES (:mail, :mdp, 2)");
                    $req->fetch(PDO::FETCH_ASSOC);
                    $req->execute(array(
                        "mail" => $mail,
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
?>