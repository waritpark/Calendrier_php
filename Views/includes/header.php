<?php //ini_set('display_errors','off'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/base-learn/public/css/style.css">
    <link rel="stylesheet" href="http://localhost/base-learn/public/css/calendar.css">
    <title><?= isset($title) ? h($title) : 'Mon calendrier';?></title>
</head>
<body>
    <header class="container-fluid py-3 bg-light">
    <?php if(isset($_SESSION['id_utilisateur'])) { ?>
        <nav class="position-relative">
            <ul class="nav flex-row align-items-center">
                <a class="text-sm-center nav-link text-dark" href="../../Views/calendar/dashboard.php"><h1 class="font-family-roboto"><li>base-learn</li></h1></a>
                <a class="text-sm-center nav-link text-dark" href="../../Views/calendar/dashboard.php"><li>Mon calendrier</li></a>
                <a class="text-sm-center nav-link text-dark" href="../../Views/calendar/ajout-evenement.php"><li>Nouvel événement</li></a>
                <a class="text-sm-center nav-link text-dark" href="../../Views/users/compte-user.php"><li>Mon compte</li></a>
                <?php if($_SESSION['role_user']==1): ?>
                    <a class="text-sm-center nav-link text-dark" href="../calendar/stats.php"><li>Statistiques</li></a>
                <?php endif;?>
                <a class="position-absolute right-70 text-sm-center nav-link text-dark" href="../../App/deconnexion.php"><li>Déconnexion</li></a>
            </ul>
        </nav>
        <?php } else {?>
        <nav class="position-relative">
            <ul class="nav flex-row align-items-center">
                <a class="text-sm-center nav-link text-dark" href="http://localhost/base-learn/"><h1 class="font-family-roboto"><li>base-learn</li></h1></a>
                <a class="text-sm-center nav-link text-dark" href="http://localhost/base-learn/"><li>Accueil</li></a>
                <a class="text-sm-center nav-link text-dark" href="http://localhost/base-learn/Forms/connexion.php"><li>Connexion</li></a>
                <a class="text-sm-center nav-link text-dark" href="http://localhost/base-learn/Forms/inscription.php"><li>Inscription</li></a>
            </ul>
        </nav>
        <?php }?>
    </header>
    <div class="height-body container mt-4">


        
        