<?php
require_once('./inc/init.php');
require_once('./inc/header.inc.php');

if(!userConnected()){
    header('Location: connexion.php');  
};

// Unsubscribe management
if(isset($_GET['action']) && $_GET['action'] == 'unsubscribe'){
    // Gathering member id from SESSION
    $id = $_SESSION['membre']['id_membre'];
    // Delete member from database
    $stmt = $pdo->prepare("DELETE FROM membre WHERE id_membre = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    session_destroy();
    $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre compte a bien été supprimé</div>';
    header('Refresh:3;url=index.php');
}

?>

 
<div class="flex column align_center m_tb_2 flex_1">
    <h3 class="font_2 m_tb_2">Cliquez sur le bouton ci_dessous pour supprimer votre compte</h3>
    <?= $success; ?>

    <a class="decoration_none self_center" href="unsubscribe.php?action=unsubscribe" onclick="confirmDelete()"> 
        <button class="" >
            Me désinscrire
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button></a>
 

<?php
require_once('./inc/bottomPage.inc.php');

?> 