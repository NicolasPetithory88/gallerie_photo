<?php
require_once('../inc/init.php');
require_once('../inc/topPageAdmin.php');

if(!userisAdmin()){
    header('Location: index.php');
    exit();  
};

// Gathering picture related datas
$stmt = $pdo->prepare("SELECT * FROM picture WHERE id_picture = :id_picture");
$stmt->bindParam(':id_picture', $_GET['id_picture'], PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll();
$data1 = $data[0][1];
$data2 = $data[0][2];
$data3 = $data[0][3];
$data4 = $data[0][4];

$reqThemes = $pdo->prepare("SELECT * FROM theme");
$reqThemes->execute();
$themes = $reqThemes->fetchAll(PDO::FETCH_ASSOC);

// Updating picture
if($_POST){

    foreach($_POST as $key => $valeur){
        $_POST[$key] = htmlspecialchars(addslashes($valeur));
    }
    
    if(!empty($_POST['title'])){
        $title = $_POST['title'];
    }
    else{
        $title = ''; 
    }
      
    if(!empty($_POST['description'])){
        $description = $_POST['description'];
    }
    else{
        $description = ''; 
    }
     
    if($_FILES['link']['error']!==4){

        $nomImg = time().'_'. $_FILES['link']['name'];             
        $img_bdd = URL . "/images_ref/$nomImg";
        define("BASE",$_SERVER['DOCUMENT_ROOT'].'/php/ProjetBoutique/'); 
        $img_doc = BASE."images_ref/$nomImg";
    
    
        if ($_FILES['link']['size'] <= 20000000){ 
            $info = pathinfo($_FILES['link']['name']);
            $ext = $info['extension'];
            $tableExt = ['jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG','Jpg','Jpeg','Png','Gif'];
    
            if(in_array($ext,$tableExt)){
                copy($_FILES['link']['tmp_name'],$img_doc); 
    
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
  
    if(!empty($_POST['id_theme'])){
        $id_theme = $_POST['id_theme'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le thème est obligatoire'.'</div>'; 
    }
    
    if($error === ''){
        global $img_bdd;
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre photo a bien été modifiée</div>';
        $stmt = $pdo->prepare("UPDATE picture SET link = :link, id_theme = :id_theme, title = :title, description = :description WHERE id_picture = :id_picture");
        $stmt->bindParam(':link', $img_bdd, PDO::PARAM_STR);
        $stmt->bindParam(':id_theme', $id_theme, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id_picture', $_GET['id_picture'], PDO::PARAM_INT);
        $stmt->execute();
        header('Refresh:3;url=picture_management.php');
    }
    }
?> 

<div class="flex column align_center p_1">

    <h3 class="font_2">Modifier une photo</h3>

    <?= $error; ?>
    <?= $success; ?>
    <!-- Picture update form -->
    <form class="flex column w_50" action="" method="POST" enctype="multipart/form-data"> 

        <label class="m_b_05" for="title">Titre</label>
        <input class="h_2 m_b_2" type="text" name="title" id="title" value="<?= $data3 ?>">

        <label class="m_b_05" for="description">Description</label>
        <textarea class="m_b_2" name="description" id="description" cols="30" rows="10" ><?= $data4 ?></textarea>

        <label class="m_b_05" for="link">Vignette du thème</label>
        <?= '<img src="'.$data2.'" class="img-produit">'; ?> 
        <input class="h_2 m_b_2" type="file" name="link" id="link">

        <legend class="m_b_05">Thème</legend>
        <select class="h_2 m_b_2" name="id_theme" id="id_theme">
        <?php
        foreach ($themes as $index => $value) {
            $selected = ($value['id_theme'] == $data1) ? 'selected' : '';
            echo '<option value="' . $value['id_theme'] . '" ' . $selected . '>' . $value['title'] . '</option>';
        }
        ?>
        </select>

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
