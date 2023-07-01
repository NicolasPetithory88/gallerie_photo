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
<body class="grace">
    
<header class="flex gap_1 bg_black p_2_1 poppins c_grey">
    <a href="http://localhost/PHP/gallerie_photo/admin/dashboard.php"class="decoration_none c_grey font_2 m_r_2">BackOffice</a>
    <nav class="flex gap_1 style_none align_center">
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/admin/theme_management.php') ? ' c_red' : ' c_grey' ?>" href="http://localhost/PHP/gallerie_photo/admin/theme_management.php">Gestion des thèmes</a>
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/admin/picture_management.php') ? ' c_red' : ' c_grey' ?>" href="http://localhost/PHP/gallerie_photo/admin/picture_management.php">Gestion des photos</a>
        <a class="decoration_none font_1_2<?= ($_SERVER['PHP_SELF'] === '/PHP/gallerie_photo/admin/membre_management.php') ? ' c_red' : ' c_grey' ?>" href="http://localhost/PHP/gallerie_photo/admin/membre_management.php">Gestion des membres</a>
        <a class="decoration_none font_1_2 c_grey" href="<?= URL?>index.php" class="back-rubrique">Retour Accueil</a>
    </nav>
</header>
