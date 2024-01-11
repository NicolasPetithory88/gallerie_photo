<?php
require_once('../inc/init.php');
require_once('../inc/topPageAdmin.php');
if(!userisAdmin()){
    header('Location: accueil.php');
    exit();  
};

// Category deletion
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $stmt = $pdo->prepare("DELETE FROM category WHERE id_category = :id_category");
    $stmt->bindParam(':id_category', $_GET['id_category'], PDO::PARAM_INT);
    $stmt->execute();
}

// Category add/update
if($_POST){
    foreach($_POST as $key => $value){
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }


    if(!empty($_POST['category_name'])){
        $category_name = $_POST['category_name'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le nom de la catégory est obligatoire'.'</div>'; 
    }



    if($_FILES['picture_link']['error']!==4){

        $nomImg = time().'_'. $_FILES['picture_link']['name']; 
        
        $img_bdd = URL . "images_ref/$nomImg";

        define("BASE",$_SERVER['DOCUMENT_ROOT'].'/PHP/gallerie_photo_local/'); 

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
        $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre catégorie a bien été ajoutée</div>';
        $stmt = $pdo->prepare("INSERT INTO category (category_name, category_picture) VALUES (:category_name, :img_bdd)");
        $stmt->bindParam(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':img_bdd', $img_bdd, PDO::PARAM_STR);
        $stmt->execute();
    }
}
?>  

<div class="flex column align_center p_1">

    <h3 class="font_2 m_tb_2">Modifier/Supprimer une des <?php $req=$pdo->query("SELECT * FROM category ");echo $req->rowCount()?> Catégories</h3>
    <!-- Categories chart -->
    <?php
    $req = $pdo->prepare("SELECT * FROM category");
    $req->execute();
    $donnee = $req->fetchALL(PDO::FETCH_ASSOC);

    echo '<table class="w_100 m_b_2 collapse">
            <thead class="bg_blue">';
    for ($i=0; $i < $req->columnCount(); $i++){
        $colone = $req->getColumnMeta($i);
        if ($colone['name'] == 'category_picture'){
            echo '<th class="p_l_1 text_left w_20">' .$colone['name'] . '</th>';
        }
        else {
        echo '<th class="p_l_1 text_left">' .$colone['name'] . '</th>';
        }
    }
        echo '<th class="p_l_1 text_left">' .'modifier' . '</th>
            <th class="p_l_1 text_left">' .'supprimer' . '</th>
            </thead>
            <tbody>';
    foreach ($donnee as $index => $value){
        echo '<tr>';
            foreach ($value as $key => $data) {
                if ($key == 'id_category'){
                    $id = $data;
                }
                if ($key == 'category_picture'){
                    echo '<td class="p_l_1 line_h_1"><img class="h_5 w_auto" src="'. $data.'"></td>';
                }
                else{
                    echo '<td class="p_l_1">' . (isset($data) ? substr($data, 0, 20) : '') . '</td>';
                }
                        
            }
            echo '<td class="p_l_1"><a class="decoration_none" href="'.URL.'admin/category_update.php?id_category='.$id.'">🖊️</a></td>';
            echo '<td class="p_l_1"><a class="decoration_none" href="'.URL.'admin/category_management.php?action=delete&id_category='.$id.'" onclick="return confirmDelete();">🚮</a></td>'; 
        echo '</tr>';
        }
    echo '</tbody></table>';

    ?>
    <?= $error; ?>
    <?= $success; ?>
    <h3 class="font_2">Ajouter une catégorie</h3>
    <!-- Category add form -->
    <form class="flex column w_50" action="" method="POST" enctype="multipart/form-data"> 

        <label class="m_b_05" for="category_name">Nom de la catégorie</label>
        <input class="h_2 m_b_2" type="text" name="category_name" id="category_name" placeholder="&nbsp;&nbsp;Nom de la catégorie">

        <label class="m_b_05" for="picture_link">Image vitrine</label>
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