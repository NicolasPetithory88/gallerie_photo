<?php
require_once('./inc/init.php');
require_once('./inc/header.inc.php');
?>  

<?php
// Gathering categories and solo themes data
$req_categories = $pdo->query("SELECT * FROM category");     
if($req_categories->rowCount() > 0){
$categories = $req_categories->fetchALL(PDO::FETCH_ASSOC);};

$req_themes = $pdo->query("SELECT * FROM theme WHERE id_category = 1");
if($req_themes->rowCount() > 0){
$themes = $req_themes->fetchALL(PDO::FETCH_ASSOC);};
?>

<div class="flex column align_center m_tb_3 flex_1 w_100">
    <!-- Categories + Themes display -->
    <ul class="flex wrap gap_1 w_90 justify_center">
        <?php 
        foreach ($categories as $key => $value) {
            if ($value['id_category'] !== 1) {
            echo  '<li class="flex column justify_center align_center"> 
                <a href="category.php?id_category='.$value['id_category'].'"><img class="w_auto h_15r" src="'. $value['category_picture'].'"></a>
                <a class="decoration_none c_black font_1_2 bold" href="category.php?id_category='.$value['id_category'].'">'.$value['category_name'].'</a>
            </li>';
            }           
        }
        foreach ($themes as $key => $value) {
            echo  '<li class="flex column justify_center align_center"> 
                <a href="theme.php?id_theme='.$value['id_theme'].'"><img class="w_auto h_15r" src="'. $value['picture_link'].'"></a>
                <a class="decoration_none c_black font_1_2 bold" href="theme.php?id_theme='.$value['id_theme'].'">'.$value['title'].'</a>
            </li>'; 
            }   
        ?>
    </ul>

<?php
require_once('./inc/bottomPage.inc.php');

?> 