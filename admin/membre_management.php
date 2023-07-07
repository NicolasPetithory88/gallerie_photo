<?php
    require_once('../inc/init.php');
    require_once('../inc/topPageAdmin.php');
    if(!userisAdmin()){
        header('Location: index.php');
        exit();  
    };

    // Member deletion
    if(isset($_GET['action']) && $_GET['action'] == 'delete'){
        $pdo->query("DELETE FROM membre
        WHERE id_membre = $_GET[id_membre]");
    }

    // Member status update
    if($_POST){

        foreach($_POST as $key => $value){
            $_POST[$key] = htmlspecialchars(addslashes($value));
        }
/*    
    if(!empty($_POST['nickname'])){
        $nickname = $_POST['nickname'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le pseudo est obligatoire'.'</div>'; 
    }

    if(!empty($_POST['password'])){
        if($_POST['password'] == $data2){
            $passwordHash = $data2;
        }
        else{
            $password = $_POST['password'];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT); 
        }
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Le mot de passe est obligatoire'.'</div>'; 
    }
    
    
    if(!empty($_POST['email'])){
        $email = $_POST['email'];
    }
    else{
        $error .= '<div class="c_red font_1_2 m_tb_1">Un email est obligatoire'.'</div>'; 
    }
    
*/
        if(($_POST['status'] === "0" || $_POST['status'] === "1")){
            $status = $_POST['status'];      
        }
        else{
            $error .= '<div class="c_red font_1_2 m_tb_1">Le statut est obligatoire'.'</div>'; 
        }

        if($error === ''){
       
            $stmt = $pdo->prepare("UPDATE membre SET /*nickname = :nickname, password = :password, email = :email,*/ status = :status WHERE id_membre = :id_membre");
            // $stmt->bindParam(':nickname', $nickname);
            // $stmt->bindParam(':password', $passwordHash);
            // $stmt->bindParam(':email', $email);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id_membre', $_GET['id_membre']);
            $stmt->execute();
            $success .= '<div class="bg_green c_white p_1_2 m_tb_1 font_1_2">Votre modification a bien été prise en compte</div>';
        }
    }
?> 

<div class="flex column align_center p_1">

    <!-- Members chart -->
    <h3 class="font_2 m_tb_2">Modifier/Supprimer un membre</h3>
    <?php
        $req = $pdo->query("SELECT * FROM membre ");
        $donnee = $req->fetchALL(PDO::FETCH_ASSOC);
        echo '<table class="w_100 m_b_2 collapse">
        <thead class="bg_blue">';
        for ($i=0; $i < $req->columnCount(); $i++){
            $colone = $req->getColumnMeta($i);
            echo '<th class="p_l_1 text_left">' .$colone['name'] . '</th>';
            }
            echo '<th class="p_l_1 text_left">' .'modifier' . '</th>
            <th class="p_l_1 text_left">' .'supprimer' . '</th>
            </thead>
            <tbody>';
            foreach ($donnee as $index => $value){
                echo "<tr>";
            foreach ($value as $key => $data) {
                if ($key == 'id_membre'){
                    echo '<td class="p_l_1">'. $data.'</td>';
                    $id = $data;
                }
                else{
                    echo '<td class="p_l_1">'. $data.'</td>';
                }
                      
            }
            echo '<td class="p_l_1"><a class="decoration_none" href="http://localhost/PHP/gallerie_photo/admin/membre_management.php?action=update&id_membre='.$id.'">🖊️</a></td>'; 
            echo '<td class="p_l_1"><a class="decoration_none" href="http://localhost/PHP/gallerie_photo/admin/membre_management.php?action=delete&id_membre='.$id.'" onclick="return confirmDelete();">🚮</a></td>';
            echo "</tr>";
        }
        echo '</tbody></table>';

        // Member update form
        if(isset($_GET['action']) && $_GET['action'] == 'update'){
            $req = $pdo->query("SELECT * FROM membre WHERE id_membre = '".$_GET['id_membre']."'");
            $data = $req->fetchAll();
            $data1 = $data[0][1];
            $data2 = $data[0][2];
            $data3 = $data[0][3];
            $data4 = $data[0][4];

            echo'
            <h3 class="font_2 m_b_2">Modifier un membre</h3>
            '.$success.'
            '.$error.'
            <form class="flex column w_50" action="" method="POST"> 
                <legend class="m_b_05 font_1_2">Membre: '.$data1.'</legend>';
/*    
         <label class="m_b_05" for="nickname">Pseudo</label>
         <input class="h_2 m_b_2" type="text" name="nickname" id="nickname" value="'.$data1.'">
 
         <label class="m_b_05" for="password">Mot de passe</label>
         <input class="h_2 m_b_2" type="password" name="password" id="password" value="'.$data3.'">
 
         <label class="m_b_05" for="email">Email</label>
         <input class="h_2 m_b_2" type="text" name="email" id="email" value="'.$data2.'">
*/
                echo'    
                <legend class="m_b_05">Statut</legend>
                <div class="flex gap_1 align_center m_b_2">';
                    if($data4=="0"){echo'<input type="radio" name="status" id="0" value="0" checked>';}
                    else{echo'<input type="radio" name="status" id="0" value="0">';}
                    echo'<label for="0">Non Admin</label>
                    <p>   &nbsp;-&nbsp;   </p>
                    <label for="1">Admin</label>';
                    if($data4=="1"){echo'<input type="radio" name="status" id="1" value="1" checked>';}
                    else{echo'<input type="radio" name="status" id="1" value="1">';}
                echo'
                </div>
                <button class="self_center" type="submit">
                    Modifier
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
        
            </form>';
}

require_once('../inc/bottomPageAdmin.php');
?> 