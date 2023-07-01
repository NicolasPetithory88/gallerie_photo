<?php
require_once('init.php');
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Voyages de Philippe</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body class="bg_grey grace">
    <div class="flex column min_h_100">
        <header class="flex bg_black p_2_1 poppins">
            <a class="c_grey decoration_none font_2" href="<?= URL?>index.php">Les Voyages de Philippe</a>
            <nav class="flex wrap align_center gap_1 m_l_5">

                <?php if(userisAdmin()): ?>   
                <a class="c_grey decoration_none font_12" href="http://localhost/PHP/gallerie_photo/admin/dashboard.php">BACKOFFICE</a>
            <?php endif ?> 

            <?php if(userConnected()): ?>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/index.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>index.php">Accueil</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/themes.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>themes.php">Thèmes</a>
                <a class="c_grey decoration_none font_1_2" href="<?= URL?>connexion.php?action=deconnexion">Déconnexion</a>     
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/unsubscribe.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>unsubscribe.php">Désinscription</a>

            <?php else : ?>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/index.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>index.php">Accueil</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/subscription.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>subscription.php">Inscription</a> 
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/themes.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>themes.php">Thèmes</a>
                <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/connexion.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>connexion.php">Connexion</a>
                 
            <?php endif ?> 
            
            </nav>
        </header>

