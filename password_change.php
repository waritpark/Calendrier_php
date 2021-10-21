<?php
session_start();
$_SESSION['changermdp']=[];
include('bdd.php');

if(isset($_POST['old_password'])
&& isset($_POST['mail'])  
&& isset($_POST['new_password']) 
&& isset($_POST['repeat_password']) 
&& !empty($_POST['old_password'])
&& !empty($_POST['mail'])  
&& !empty($_POST['new_password']) 
&& !empty($_POST['repeat_password']) 
&& $_POST['new_password']===$_POST['repeat_password']){
    $mail=$_POST['mail']; 
    $oldMdp=$_POST['old_password'];
    $newMdp=password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    $req2=$bdd->prepare("UPDATE utilisateur SET mdp =? WHERE mail=$mail ");
    $req2->execute([$newMdp]);

    array_push($_SESSION['changermdp'],["", "Vous avez changé de mot de passe !"]);
    header("Location:connexion.php");
}
else {
    array_push($_SESSION['changermdp'],["Erreur.", ""]);
    header("Refresh: 2");
}
