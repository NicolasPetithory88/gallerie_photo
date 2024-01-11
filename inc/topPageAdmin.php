<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Voyages de Philippe</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <script src="../script.js"></script>
</head>
<body class="poppins">
    
<header class="flex gap_1 bg_black p_2_1 poppins c_grey">
<a class="decoration_none font_2 c_grey m_r_2" href="<?= URL?>index.php" class="back-rubrique">Retour Accueil</a>
    
    <nav class="flex gap_1 style_none align_center">
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/admin/dashboard.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>admin/dashboard.php">BackOffice</a>
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/admin/category_management.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>admin/category_management.php">Gestion des catégories</a>
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/admin/theme_management.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>admin/theme_management.php">Gestion des thèmes</a>
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/admin/picture_management.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>admin/picture_management.php">Gestion des photos</a>
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/admin/membre_management.php') ? ' c_red' : ' c_grey' ?>" href="<?= URL?>admin/membre_management.php">Gestion des membres</a>
        
    </nav>
</header>
