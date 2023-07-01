<?php
require_once('../inc/init.php');
require_once('../inc/topPageAdmin.php');

if(!userisAdmin()){
    header('Location: accueil.php');
    exit();  
};

// Theme deletion
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $pdo->query("DELETE FROM theme
    WHERE id_theme = $_GET[id_theme]");
}

// Theme add/update
if($_POST){
    foreach($_POST as $key => $value){
        $_POST[$key] = htmlspecialchars(addslashes($value));
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
        $description = ''; 
    }


    if($_FILES['picture_link']['error']!==4){

        $nomImg = time().'_'. $_FILES['picture_link']['name']; 

        
        
        $img_bdd = URL2 . "ProjetBoutique/images_ref/$nomImg";

        define("BASE",$_SERVER['DOCUMENT_ROOT'].'/php/ProjetBoutique/'); 

        $img_doc = BASE."images_ref/$nomImg";


        if ($_FILES['picture_link']['size'] <= 20000000){ 
            $ext = pathinfo($_FILES['picture_link']['name'],PATHINFO_EXTENSION);

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
        $error .= '<div class="c_red font_1_2 m_tb_1">L\'image est obligatoire'.'</div>'; 
    }



    if($error === ''){
        global $img_bdd;
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre produit a bien été ajouté</div>';
        $pdo->query("INSERT INTO theme (title,description,picture_link) VALUES ('$title','$description','$img_bdd')");
    }
}
?>  

<div class="flex column align_center p_1">

    <h3 class="font_2 m_tb_2">Modifier/Supprimer un des <?php $req=$pdo->query("SELECT * FROM theme ");echo $req->rowCount()?> Thèmes</h3>
    <!-- Themes chart -->
    <?php
    $req = $pdo->query("SELECT * FROM theme ");
    $donnee = $req->fetchALL(PDO::FETCH_ASSOC);

    echo '<table class="w_100 m_b_2 collapse">
            <thead class="bg_blue">';
    for ($i=0; $i < $req->columnCount(); $i++){
        $colone = $req->getColumnMeta($i);
        if ($colone['name'] == 'picture_link'){
            echo '<th class="text_left w_20">' .$colone['name'] . '</th>';
        }
        else {
        echo '<th class="text_left">' .$colone['name'] . '</th>';
        }
    }
        echo '<th class="text_left">' .'modifier' . '</th>
            <th class="text_left">' .'supprimer' . '</th>
            </thead>
            <tbody>';
    foreach ($donnee as $index => $value){
        echo '<tr>';
            foreach ($value as $key => $data) {
                if ($key == 'id_theme'){
                    $id = $data;
                }
                if ($key == 'picture_link'){
                    echo '<td><img class="w_40 auto" src="'. $data.'"></td>';
                }
                else{
                    echo '<td>'. substr($data,0,20).'</td>';
                }
                        
            }
            echo '<td><a class="decoration_none" href="http://localhost/PHP/gallerie_photo/admin/theme_update.php?id_theme='.$id.'">🖊️</a></td>';
            echo '<td><a class="decoration_none" href="http://localhost/PHP/gallerie_photo/admin/theme_management.php?action=delete&id_theme='.$id.'" onclick="return confirmDelete();">🚮</a></td>'; 
        echo '</tr>';
        }
    echo '</tbody></table>';

    ?>
    <?= $error; ?>
    <?= $success; ?>
    <h3 class="font_2">Ajoutez un thème</h3>
    <!-- Theme add form -->
    <form class="flex column w_50" action="" method="POST" enctype="multipart/form-data"> 

        <label class="m_b_05" for="title">Titre</label>
        <input class="h_2 m_b_2" type="text" name="title" id="title" placeholder="&nbsp;&nbsp;Votre titre">

        <label class="m_b_05" for="description">Description</label>
        <textarea class=" m_b_2" name="description" id="description" cols="30" rows="10" placeholder="&nbsp;description"></textarea>

        <label class="m_b_05" for="picture_link">Vitrine photo</label>
        <input class="h_2 m_b_2" type="file" name="picture_link" id="picture_link" placeholder="&nbsp;&nbsp;Votre image">

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