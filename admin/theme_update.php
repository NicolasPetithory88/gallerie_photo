<?php
require_once('../inc/init.php');
require_once('../inc/topPageAdmin.php');

if(!userisAdmin()){
    header('Location: index.php');
    exit();  
};
// Gathering theme data
$req = $pdo->prepare("SELECT * FROM theme WHERE id_theme = :id_theme");
$req->bindParam(':id_theme', $_GET['id_theme'], PDO::PARAM_INT);
$req->execute();
$data = $req->fetchAll();
$data1 = $data[0][1];
$data2 = $data[0][2];
$data3 = $data[0][3];

// Updating theme
if($_POST){

    foreach($_POST as $key => $valeur){
        $_POST[$key] = htmlspecialchars(addslashes($valeur));
    }
    
     
    if(!empty($_POST['title'])){
        $title = $_POST['title'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le titre est obligatoire'.'</div>'; 
    }
    
    
    if(!empty($_POST['description'])){
        $description = $_POST['description'];
    }
    else{
        $error = ''; 
    }
     
    
    if($_FILES['picture_link']['error']!==4){

        $nomImg = time().'_'. $_FILES['picture_link']['name'];       

        $img_bdd = URL . "/images_ref/$nomImg";

        define("BASE",$_SERVER['DOCUMENT_ROOT'].'/PHP/gallerie_photo_local/'); 

        $img_doc = BASE."images_ref/$nomImg";
    
    
        if ($_FILES['picture_link']['size'] <= 20000000){ 
            $info = pathinfo($_FILES['picture_link']['name']);
            $ext = $info['extension'];
            $tableExt = ['jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG','Jpg','Jpeg','Png','Gif'];
    
            if(in_array($ext,$tableExt)){
                copy($_FILES['picture_link']['tmp_name'],$img_doc); 
    
            }
            else{
                $error .= '<div class="c_red font_1_2 m_tb_1">Format d\'image non autorisé'.'</div>'; 
            }
        } 
        else{
            $error .= '<div class="c_red font_1_2 m_tb_1">La taille de l\'image doit être inférieur à 20mo'.'</div>'; ;
        }
    }
    else{
         $img_bdd=$data3; 
    }
    
    
    if($error === ''){
        global $img_bdd;
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre thème a bien été modifié</div>';
        $stmt = $pdo->prepare("UPDATE theme SET title = :title, description = :description, picture_link = :img_bdd WHERE id_theme = :id_theme");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':img_bdd', $img_bdd, PDO::PARAM_STR);
        $stmt->bindParam(':id_theme', $_GET['id_theme'], PDO::PARAM_INT);
        $stmt->execute();
        header('Refresh:3;url=theme_management.php');
    }
    }
?> 

<div class="flex column align_center p_1">

    <h3 class="font_2">Modifier un thème</h3>

    <?= $error; ?>
    <?= $success; ?>
    <!-- Theme update form  -->
    <form class="flex column w_50" action="" method="POST" enctype="multipart/form-data"> 

        <label class="m_b_05" for="title">Titre</label>
        <input class="h_2 m_b_2" type="text" name="title" id="title" value="<?= $data1 ?>">

        <label class="m_b_05" for="description">Description</label>
        <textarea class="m_b_2" name="description" id="description" cols="30" rows="10" ><?= $data2 ?></textarea>

        <label class="m_b_05" for="picture_link">Vignette du theme</label>
        <?= '<img class="m_b_2" src="'.$data3.'" class="img-produit">'; ?> 
        <input class="h_2 m_b_2" type="file" name="picture_link" id="picture_link">

        <button class="self_center" type="submit">
            Modifier
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </form>

<?php
require_once('../inc/bottomPageAdmin.php');
?> 
