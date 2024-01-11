<?php
require_once('../inc/init.php');
require_once('../inc/topPageAdmin.php');

if(!userisAdmin()){
    header('Location: index.php');
    exit();  
};
// Gathering theme data
$req = $pdo->prepare("SELECT * FROM category WHERE id_category = :id_category");
$req->bindParam(':id_category', $_GET['id_category'], PDO::PARAM_INT);
$req->execute();
$data = $req->fetchAll();
$data1 = $data[0][1];
$data2 = $data[0][2];


// Updating theme
if($_POST){

    foreach($_POST as $key => $valeur){
        $_POST[$key] = htmlspecialchars(addslashes($valeur));
    }
    
     
    if(!empty($_POST['category_name'])){
        $category_name = $_POST['category_name'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le nom de la catégorie est obligatoire'.'</div>'; 
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
         $img_bdd=$data2; 
    }
    
    
    if($error === ''){
        global $img_bdd;
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre thème a bien été modifié</div>';
        $stmt = $pdo->prepare("UPDATE category SET category_name = :category_name, category_picture = :img_bdd WHERE id_category = :id_category");
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':img_bdd', $img_bdd, PDO::PARAM_STR);
        $stmt->bindParam(':id_category', $_GET['id_category'], PDO::PARAM_INT);
        $stmt->execute();
        header('Refresh:3;url=category_management.php');
    }
    }
?> 

<div class="flex column align_center p_1">

    <h3 class="font_2">Modifier une catégorie</h3>

    <?= $error; ?>
    <?= $success; ?>
    <!-- Theme update form  -->
    <form class="flex column w_50" action="" method="POST" enctype="multipart/form-data"> 

        <label class="m_b_05" for="category_name">Titre</label>
        <input class="h_2 m_b_2" type="text" name="category_name" id="category_name" value="<?= $data1 ?>">

        <label class="m_b_05" for="picture_link">Image vitrine</label>
        <?= '<img class="m_b_2" src="'.$data2.'" class="img-produit">'; ?> 
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
