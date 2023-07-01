<?php
require_once('./inc/header.inc.php');
require_once('./inc/init.php');
?>


<div class="flex column align_center m_tb_2 flex_1">
    <?php
    // Redirect to main page if no id_theme was found in url
    if(!isset($_GET['id_theme'])){
        header('Location:index.php');
    }
    // Gathering theme data
    else{
        $reqtheme = $pdo->query("SELECT * FROM theme WHERE id_theme = '$_GET[id_theme]'");
        $theme = $reqtheme->fetch(PDO::FETCH_ASSOC);
        echo '<h1 class="font_3">'.$theme['title'].'</h1>
              <p class="m_t_1 font_1_2">'.$theme['description'].'</p>
              <div class="flex wrap gap_1 w_100 justify_center m_tb_2">';
        $reqpictures = $pdo->query("SELECT * FROM picture WHERE id_theme = '$_GET[id_theme]'");
        $pictures = $reqpictures->fetchAll(PDO::FETCH_ASSOC);
        // Pictures display
        foreach ($pictures as $key => $picture) { 
            echo '<div class="flex column w_20 justify_center align_center">';
            echo '<a href="picture.php?id_picture=' . $picture['id_picture'].'"><img class="w_100 h_auto" src="'.$picture['link'].'" width="200px"></a>
            </div>';
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