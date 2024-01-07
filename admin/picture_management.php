<?php
require_once('../inc/init.php');
require_once('../inc/topPageAdmin.php');

if(!userisAdmin()){
    header('Location: index.php');
    exit();  
};

// picture deletion
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $stmt = $pdo->prepare("DELETE FROM picture WHERE id_picture = :id_picture");
    $stmt->bindParam(':id_picture', $_GET['id_picture'], PDO::PARAM_INT);
    $stmt->execute();
}

// picture add
if($_POST){
foreach($_POST as $key => $value){
    $_POST[$key] = htmlspecialchars(addslashes($value));
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

    $img_bdd = URL . "images_ref/$nomImg";

    define("BASE",$_SERVER['DOCUMENT_ROOT'].'/PHP/gallerie_photo_local/'); 

    $img_doc = BASE."images_ref/$nomImg";


    if ($_FILES['link']['size'] <= 8000000){ 
        $ext = pathinfo($_FILES['link']['name'],PATHINFO_EXTENSION);

        $tableExt = ['jpg','JPG','jpeg','JPEG','gif','GIF','png','PNG','Jpg','Jpeg','Png','Gif'];

        if(in_array($ext,$tableExt)){
            copy($_FILES['link']['tmp_name'],$img_doc); 

        }
        else{
            $error .= '<div class="erreur">Format d\'image non autorisé'.'</div>'; 
        }
    } 
    else{
        $error .= '<div class="erreur">La taille de l\'image doit être inférieur à 8mo'.'</div>'; ;
    }
}
else{
    $error .= '<div class="erreur">L\'image est obligatoire'.'</div>'; 
}

if(!empty($_POST['id_theme'])){
    $id_theme = $_POST['id_theme'];
}
else{
    $error .= '<div class="erreur">Le thème est obligatoire'.'</div>'; 
}

if($error === ''){
    global $img_bdd;
    $success .= '<div class="class="bg_green c_white p_1_2 m_tb_1 font_1_2"">Votre photo a bien été ajoutée</div>';
    $stmt = $pdo->prepare("INSERT INTO picture (title, description, link, id_theme) VALUES (:title, :description, :link, :id_theme)");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':link', $img_bdd, PDO::PARAM_STR);
    $stmt->bindParam(':id_theme', $id_theme, PDO::PARAM_INT);
    $stmt->execute();
    
}
}
?>  

<div class="flex column align_center p_1">

    <!-- Pictures chart -->
    <h3 class="font_2 m_tb_2">Modifier/Supprimer une des <?php $req=$pdo->query("SELECT * FROM picture ");echo $req->rowCount()?> Photos</h3>

    <?php
    $req = $pdo->prepare("SELECT * FROM picture");
    $req->execute();    
    $donnee = $req->fetchALL(PDO::FETCH_ASSOC);

    echo '<table class="w_100 m_b_2 collapse">
            <thead class="bg_blue">';
    for ($i=0; $i < $req->columnCount(); $i++){
        $colone = $req->getColumnMeta($i);
        if ($colone['name'] == 'link'){
        echo '<th class="p_l_1 text_left w_20">' .$colone['name'] . '</th>';
        }
        else{
        echo '<th class="p_l_1 text_left">' .$colone['name'] . '</th>';
        }
    }
        echo '<th class="p_l_1 text_left">' .'modifier' . '</th>
            <th class="p_l_1 text_left">' .'supprimer' . '</th>
            </thead>
            <tbody>';
    foreach ($donnee as $index => $value){
        $reqTheme = $pdo->prepare("SELECT title FROM theme WHERE id_theme = :id_theme");
        $reqTheme->bindParam(':id_theme', $value['id_theme'], PDO::PARAM_INT);
        $reqTheme->execute();
        $theme = $reqTheme->fetch(PDO::FETCH_ASSOC); 
        echo '<tr>';
            foreach ($value as $key => $data) {
                if ($key == 'id_picture'){
                    $id = $data;
                }
                if ($key == 'id_theme'){
                    echo '<td class="p_l_1">'. substr($theme['title'],0,20).'</td>'; 
                }
                else if ($key == 'link'){
                    echo '<td class="p_l_1 line_h_1"><img class="h_5 w_auto" src="'. $data.'"></td>';
                }
                else{
                    echo '<td class="p_l_1">'. substr($data,0,20).'</td>';
                }
                        
            }
            echo '<td class="p_l_1"><a class="decoration_none" href="'.URL.'admin/picture_update.php?id_picture='.$id.'">🖊️</a></td>';
            echo '<td class="p_l_1"><a class="decoration_none" href="'.URL.'admin/picture_management.php?action=delete&id_picture='.$id.'" onclick="return confirmDelete();">🚮</a></td>'; 
        echo '</tr>';
        }
    echo '</tbody></table>';

    // Fetching all themes
    $reqThemes = $pdo->prepare("SELECT * FROM theme");
    $reqThemes->execute();
    $themes = $reqThemes->fetchAll(PDO::FETCH_ASSOC);

    ?>
    
    <!-- Picture add form -->
    <h3 class="font_2">Ajouter une photo</h3>
    <?= $error; ?>
    <?= $success; ?>
    <form class="flex column w_50" action="" method="POST" enctype="multipart/form-data"> 

        <label class="m_b_05" for="title">Titre</label>
        <input  class="h_2 m_b_2" type="text" name="title" id="title" placeholder="&nbsp;&nbsp;Votre titre">

        <label class="m_b_05" for="description">Description</label>
        <textarea  class="m_b_2" name="description" id="description" cols="30" rows="10" placeholder="&nbsp;description"></textarea>

        <label class="m_b_05" for="link">Photo</label>
        <input  class="h_2 m_b_2" type="file" name="link" id="link" placeholder="&nbsp;&nbsp;Votre image">

        <legend class="m_b_05">thème</legend>
        <select class="h_2 m_b_2" name="id_theme" id="id_theme">
    <?php
        foreach ($themes as $index => $value){
        echo '<option value="'.$value['id_theme'].'">'.$value['title'].'</option>';
        }
    ?>
        </select>

        <button class="self_center" type="submit">
            Ajouter
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </form>    


<?php
require_once('../inc/bottomPageAdmin.php');
?> 