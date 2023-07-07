<?php
require_once('./inc/init.php');
require_once('./inc/header.inc.php');
?>  

<?php
// Gathering themes's data
$req_themes = $pdo->query("SELECT * FROM theme");
        
    if($req_themes->rowCount() > 0){
    $themes = $req_themes->fetchALL(PDO::FETCH_ASSOC);};
?>

<div class="flex column align_center m_tb_3 flex_1">
    <!-- Themes display -->
    <ul class="flex wrap gap_1 w_100 justify_center">
        <?php 
        foreach ($themes as $key => $value) {
            echo  '<li class="flex column w_20 justify_center align_center"> 
            <a href="theme.php?id_theme='.$value['id_theme'].'"><img class="w_auto h_15r" src="'. $value['picture_link'].'"></a>
            <a class="decoration_none c_black font_1_2 bold" href="theme.php?id_theme='.$value['id_theme'].'">'.$value['title'].'</a>
            </li>';
             
            
        }
        ?>
    </ul>

<?php
require_once('./inc/bottomPage.inc.php');

?> 
