<?php
require_once('init.php');
var_dump($_SERVER['PHP_SELF']);
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Philippe Petithory | Photographe</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body class="bg_grey poppins">
    <div class="flex column min_h_100">
        <header class="flex bg_black p_2 poppins space_between">
            <a class="c_grey decoration_none font_2" href="<?= URL?>index.php">Philippe Petithory | Photographe</a>
            <nav class="flex wrap align_center gap_1 m_l_5">

                <?php if(userisAdmin()): ?>   
                <a class="c_grey decoration_none font_2" href="http://localhost/PHP/gallerie_photo/admin/dashboard.php">BACKOFFICE</a>
            <?php endif ?> 

            <?php if(userConnected()): ?>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/index.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>index.php">Accueil</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/themes.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>themes.php">Thèmes</a>
                <a class="c_grey decoration_none font_1_2" href="<?= URL?>connexion.php?action=deconnexion">Déconnexion</a>     
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/unsubscribe.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>unsubscribe.php">Désinscription</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/contact.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>contact.php">Contact</a>

            <?php else : ?>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/index.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>index.php">Accueil</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/subscription.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>subscription.php">Inscription</a> 
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/themes.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>themes.php">Thèmes</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/connexion.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>connexion.php">Connexion</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/contact.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>contact.php">Contact</a>
                 
            <?php endif ?> 
            
            </nav>
        </header>


