<?php
require_once('./inc/header.inc.php');
require_once('./inc/init.php');
require_once('./inc/mailer.php');

// Contact email management
if($_POST){

    foreach($_POST as $key => $value){
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }
    
    if(!empty($_POST['nickname'])){
        $nickname = $_POST['nickname'];
            if(strlen($nickname) < 3 || strlen($nickname)>20){
             $error .= '<div class="c_red font_1_2 m_tb_1">Votre pseudo doit contenir entre 3 et 20 characteres'.'</div>';}      
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le pseudo est obligatoire'.'</div>'; 
    }
    
    
    if(!empty($_POST['email'])){
        $email = $_POST['email'];

        if (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/', $email)) {
            $error .= '<div class="c_red font_1_2 m_tb_1">Votre email n\'est pas valide'.'</div>';
        }
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Un email est obligatoire</div>'; 
    }

    if(!empty($_POST['content'])){
        $content = $_POST['content'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Un email est obligatoire</div>'; 
    }
    
    if($error === ''){
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre message a bien été envoyé</div>';
        $pdo->query("INSERT INTO contact_message (author,email,message) VALUES ('$nickname','$email','$content')");
        $me = 'hpnyckit@gmail.com'; 
        sendmymail('Les Voyages de Philippe', $email, 'Message de '.$nickname, $content);
        header('Refresh:3;url=index.php');
    }
    }
?>  

<div class="flex column justify_center align_center flex_1">
    
    <div class="flex w_100 space_around">
        <div class="flex column w_40">
            <h1 class="self_center m_b_2">Me Contacter</h1>
            <p class="font_1_2" >Contactez-moi par téléphone ou en envoyant un message.</p>
            <p class="font_1_2 m_b_2" >Philippe Petithory : 06 50 03 97 03</p>
            <form class="flex column" action="" method="POST"> 

                <?= $error; ?>
                <?= $success; ?>

                <label class="m_b_05" for="nickname">Pseudo</label>
                <input class="m_b_2 h_2" type="text" name="nickname" id="nickname" placeholder="&nbsp;&nbsp;Votre pseudo">
                
                
                <label class="m_b_05" for="email">Email</label>
                <input class="m_b_3 h_2" type="text" name="email" id="email" placeholder="&nbsp;&nbsp;Votre adresse email">

                <textarea class="m_b_2" name="content" id="content" cols="30" rows="8" placeholder="&nbsp;Votre message"></textarea>

                <button class="self_center" type="submit">
                    Envoyer
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </form>
        </div>
        <img class="h_auto w_40" src="http://localhost/php/gallerie_photo/images_ref/1667434880_0033.jpg" alt="">
    </div>

<?php
require_once('./inc/bottomPage.inc.php');

?> 