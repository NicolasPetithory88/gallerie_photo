<?php
require_once('./inc/header.inc.php');
require_once('./inc/init.php');
?>


<div class="flex column align_center m_tb_2 flex_1 w_100">
    <?php
    // Redirect to main page if no id_theme was found in url
    if(!isset($_GET['id_theme'])){
        header('Location:index.php');
    }
    else{
        // Gathering theme data
        $reqTheme = $pdo->prepare("SELECT * FROM theme WHERE id_theme = :id_theme");
        $reqTheme->bindParam(':id_theme', $_GET['id_theme']);
        $reqTheme->execute();
        $theme = $reqTheme->fetch(PDO::FETCH_ASSOC);
        // Title and description
        echo '<h1 class="font_3">'.$theme['title'].'</h1>
              <p class="m_t_1 font_1_2">'.$theme['description'].'</p>
              <div class="flex wrap gap_1 w_90 justify_center m_tb_2">';
        // Gathering theme's pictures
        $reqPictures = $pdo->prepare("SELECT * FROM picture WHERE id_theme = :id_theme");
        $reqPictures->bindParam(':id_theme', $_GET['id_theme']);
        $reqPictures->execute();
        $pictures = $reqPictures->fetchAll(PDO::FETCH_ASSOC);
        // Pictures display
        foreach ($pictures as $key => $picture) {       
                echo '<a href="picture.php?id_picture=' . $picture['id_picture'].'"><img class="w_auto h_15r" src="'.$picture['link'].'"></a>';
            
        }    
        echo '</div>';    
    }

    ?> 

    <a class="decoration_none c_grey" href="themes.php?>">
        <button>
            Retour aux thèmes
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </a>


<?php
require_once('./inc/bottomPage.inc.php');

?> 