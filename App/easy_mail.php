<?php
session_start();
$_SESSION['recuperation']=[];

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