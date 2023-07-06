<?php
require_once('./inc/init.php');
require_once('./inc/header.inc.php');

// subscription management
if($_POST){

    foreach($_POST as $key => $value){
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }
    
    if(!empty($_POST['nickname'])){
        $nickname = $_POST['nickname'];
            if(strlen($nickname) < 3 || strlen($nickname)>20){
             $error .= '<div class="c_red font_1_2 m_tb_1">Votre pseudo doit contenir entre 3 et 20 characteres'.'</div>';
            }  
             $stmt = $pdo->prepare("SELECT * FROM membre WHERE nickname = :nickname");
             $stmt->bindParam(':nickname', $nickname);
             $stmt->execute();
             $numberOfNicknames = $stmt->rowCount();
            if($numberOfNicknames > 0){
                $error .= '<div class="c_red font_1_2 m_tb_1">Votre pseudo est déja utilisé'.'</div>';
            }        
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le pseudo est obligatoire'.'</div>'; 
    }
    
    
    if(!empty($_POST['password'])){
        $password = $_POST['password'];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le mot de passe est obligatoire</div>'; 
    }
    
    
    if(!empty($_POST['email'])){
        $email = $_POST['email'];

        if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $email)) {
            $error .= '<div class="c_red font_1_2 m_tb_1">Votre email n\'est pas valide'.'</div>';
        }
        $stmt2 = $pdo->prepare("SELECT * FROM membre WHERE email = :email");
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();
        $numberOfEmail = $stmt->rowCount();

        if($numberOfEmail > 0){
            $error .= '<div class="c_red font_1_2 m_tb_1">Cet adresse email est déja utilisée'.'</div>';
        }   
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Un email est obligatoire</div>'; 
    }
    
    if($error === ''){
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre inscription a bien été prise en compte</div>';
        $stmt3 = $pdo->prepare("INSERT INTO membre (nickname, email, password) VALUES (:nickname, :email, :passwordHash)");
        $stmt3->bindParam(':nickname', $nickname);
        $stmt3->bindParam(':email', $email);
        $stmt3->bindParam(':passwordHash', $passwordHash);
        $stmt3->execute();

        header('Refresh:3;url=connexion.php');
    }
    }
?>  
 
 

<div class="flex column align_center m_tb_2 flex_1">
    <h1 class="font_20 m_b_1">Créez votre compte</h1>   

    <?= $error; ?>
    <?= $success; ?>  
    <!-- subscription form -->
    <form class="flex column w_40 m_t_1" action="" method="POST"> 
        
        <label class="m_b_05" for="nickname">Pseudo</label>
        <input class="m_b_2 h_2" type="text" name="nickname" id="nickname" placeholder="&nbsp;&nbsp;Votre pseudo">
        
        <label class="m_b_05" for="password">Mot de passe</label>
        <input class="m_b_2 h_2" type="password" name="password" id="password" placeholder="&nbsp;&nbsp;Votre mot de passe">
        
        <label class="m_b_05" for="email">Email</label>
        <input class="m_b_3 h_2" type="text" name="email" id="email" placeholder="&nbsp;&nbsp;Votre adresse email">
        
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