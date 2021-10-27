<?php
session_start();
$_SESSION['changermdp']=[];
include('bdd.php');

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
    $verif_token=$pdo->prepare("SELECT * FROM t_recuperation WHERE token_recup=?");
    $verif_token->execute([$token]);
    $resultrow=$verif_token->fetch(PDO::FETCH_ASSOC);
    if ($resultrow) {
        $newMdp=password_hash($_POST["new_password"], PASSWORD_DEFAULT);
        $req2=$pdo->prepare("UPDATE t_utilisateur SET mdp =? WHERE mail=$mail");
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
