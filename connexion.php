<!-- Traitement -->

<?php
require_once('./inc/init.php');
require_once('./inc/header.inc.php');
// Disconnect + session'shut down
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
        session_destroy();
        header('Location: index.php');
        exit;
}

// Redirect to main page when connected
if(userConnected()){
    header('Location: themes.php');  
};

// Connexion management / session creation
if($_POST){
    if(empty($_POST['nickname'])){
        $error .= '<div class="erreur">Veuillez renseigner votre pseudo'.'</div>'; 
    }
    else{
        $nickname = $_POST['nickname'];
        $nicknameBase = $pdo->query("SELECT * FROM membre WHERE nickname = '$nickname'");
        if($nicknameBase->rowCount() > 0){
            $membre = $nicknameBase->fetchALL(PDO::FETCH_ASSOC);
            if($membre[0]['nickname']==$nickname){
            // Verification du mdp
                if(!empty($_POST['password'])){
                    if(password_verify($_POST['password'],  $membre[0]['password'])){
                        $success .= 'Connexion validée';                       
           
                        $_SESSION['membre']['id_membre'] = $membre[0]['id_membre'];
                        $_SESSION['membre']['nickname'] = $membre[0]['nickname'];
                        $_SESSION['membre']['password'] = $membre[0]['password'];
                        $_SESSION['membre']['email'] = $membre[0]['email'];
                        $_SESSION['membre']['status'] = $membre[0]['status'];
                        header('Location: index.php');
                    }    
                }
                else{
                    $error .= '<div class="erreur">Veuillez renseigner votre mot de passe'.'</div>';
                }
            }
            else{
                $error .= '<div class="erreur">Ce pseudo n\'éxiste pas'.'</div>';    
            }
        }
   
    }
}


?>  
 
<div class="flex column align_center m_tb_2 flex_1">
    <h1 class="font_20 m_b_2">Connectez-vous à votre compte</h1>  
    <!-- Connexion form -->
    <form class="flex column w_40" action="" method="POST"> 

    <?= $error; ?>
    <?= $success; ?>

        <label class="m_b_05" for="nickname">Pseudo</label>
        <input class="m_b_2 h_2" type="text" name="nickname" id="nickname" placeholder="&nbsp;&nbsp;Votre pseudo">

        <label class="m_b_05" for="password">Mot de passe</label>
        <input class="m_b_3 h_2" type="password" name="password" id="password" placeholder="&nbsp;&nbsp;Votre mot de passe">

        <button class="self_center" type="submit">
            Valider
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </form>

<?php
require_once('./inc/bottomPage.inc.php');

?> 