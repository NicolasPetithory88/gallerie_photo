<?php
require_once('C:\wamp64\www\PHP\gallerie_photo\inc\init.php');
require_once('../inc/topPageAdmin.php');
?>  

<?php
if(!userisAdmin()){
    header('Location: index.php');
    exit();  
};
?> 


<div class="flex column align_center justify_center m_tb_2">
    <h1 class="m_b_2">Bienvenue sur le BACKOFFICE</h1>
    <h3>Selectionnez l'une des rubriques dans le menu du haut.</h3>


<?php
require_once('../inc/bottomPageAdmin.php');
?> 