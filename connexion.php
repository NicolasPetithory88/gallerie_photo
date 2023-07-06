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
    header('Location: index.php');  
};

// Connexion management / session creation
if ($_POST) {

    if (empty($_POST['nickname'])) {
        $error .= '<div class="c_red font_1_2 m_tb_1">Veuillez renseigner votre pseudo'.'</div>';
    } else {
        $nickname = $_POST['nickname'];
        $stmt = $pdo->prepare("SELECT * FROM membre WHERE nickname = :nickname");
        $stmt->execute([':nickname' => $nickname]);
        $membre = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            if ($membre['nickname'] == $nickname) {
                // Password checking
                if (!empty($_POST['password'])) {
                    if (password_verify($_POST['password'], $membre['password'])) {
                        $success .= 'Connexion validée';

                        $_SESSION['membre']['id_membre'] = $membre['id_membre'];
                        $_SESSION['membre']['nickname'] = $membre['nickname'];
                        $_SESSION['membre']['password'] = $membre['password'];
                        $_SESSION['membre']['email'] = $membre['email'];
                        $_SESSION['membre']['status'] = $membre['status'];
                        header('Location: index.php');
                    }
                    else{
                        $error .= '<div class="c_red font_1_2 m_tb_1">Le mot de passe est incorrect'.'</div>';
                    }
                } 
                else {
                    $error .= '<div class="c_red font_1_2 m_tb_1">Veuillez renseigner votre mot de passe'.'</div>';
                }
            }           
        }
        else {
            $error .= '<div class="c_red font_1_2 m_tb_1">Ce pseudo n\'existe pas'.'</div>';
        }
    }
}


?>  
 
<div class="flex column align_center justify_center flex_1">
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