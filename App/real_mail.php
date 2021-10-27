<?php
session_start();
$_SESSION['recuperation']=[];
include('bdd.php');

if(isset($_POST['pseudo']) 
&& isset($_POST['mail']) 
&& !empty($_POST['pseudo']) 
&& !empty($_POST['mail'])
&& filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)) {
    $pseudo=$_POST['pseudo'];
    $mail=$_POST['mail'];
    $req1=$pdo->prepare("SELECT * FROM t_utilisateur WHERE mail= ?");
    $req1->execute([$mail]);
    $resultrow=$req1->fetch(PDO::FETCH_ASSOC);
    if ($resultrow) {
        $string = implode('', array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9')));
        $token = substr(str_shuffle($string), 0, 20);
        $_SESSION['mail_change'] = $token;

        $mail_recup_exist = $pdo->prepare("SELECT ID_recup FROM t_recuperation WHERE mail_recup=?");
        $mail_recup_exist->execute(array($recup_mail));
        $mail_recup_exist=$mail_recup_exist->rowCount();
        if ($mail_recup_exist==1) {
            $req2=$pdo->prepare("UPDATE t_recuperation SET token_recup=? WHERE mail_recup=?");
            $req2->execute([$token, $_POST["mail"]]);
        } else {
            $req2=$pdo->prepare("INSERT INTO t_recuperation(mail_recup,token_recup) VALUES (?, ?)");
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
