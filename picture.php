<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Voyages de Philippe</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body class="bg_grey poppins">
    <div class="flex column h_100 min_h_100">
    <?php

    require_once('./inc/init.php');
    $id_picture = $_GET['id_picture'];

    if(isset($_GET['action'])) {
        // Gathering url data
        $action = $_GET['action'];
        $id_comment = $_GET['id_comment'];
        $author = $_SESSION['membre']['nickname'];
        // Check if the logged-in user is the owner of the comment
        $reqComment = $pdo->prepare("SELECT author, id_picture FROM comment WHERE id_comment = :id_comment");
        $reqComment->bindValue(':id_comment', $id_comment);
        $reqComment->execute();
        $comment = $reqComment->fetch(PDO::FETCH_ASSOC);

        // comment deletion
        if($action == 'delete'){

            if($comment && $comment['author'] == $_SESSION['membre']['nickname'] || $comment && userisAdmin()) {
                $commentDelete = $pdo->prepare("DELETE FROM comment WHERE id_comment = :id_comment");
                $commentDelete->bindParam(':id_comment', $id_comment);
                $commentDelete->execute();
            }
            header('Location: picture.php?id_picture='.$comment['id_picture']);
            exit;

        } elseif($action == 'edit') {
        // comment edition
            if($_POST){
                foreach($_POST as $key => $value){
                    $_POST[$key] = htmlspecialchars(addslashes($value));
                }

                if(!empty($_POST['content'])){
                    $content = $_POST['content'];
                }
                else{
                    $error = '<div class="c_red font_1_2 m_tb_1">Votre commentaire est vide</div>'; 
                }
                if($error === ''){
                    $commentEdit = $pdo->prepare("UPDATE comment SET content = :content WHERE id_comment = :id_comment");
                    $commentEdit->bindParam(':content', $content);
                    $commentEdit->bindParam(':id_comment', $id_comment);
                    $commentEdit->execute();
                    header('Location: picture.php?id_picture='.$comment['id_picture']);
                    exit;
                }
            }
        }
    }
    else {
        if($_POST){
            // comment add
            $author = $_SESSION['membre']['nickname'];
            foreach($_POST as $key => $value){
                $_POST[$key] = htmlspecialchars(addslashes($value));
            }
        
            if(!empty($_POST['content'])){
                $content = $_POST['content'];
            }
            else{
                $error = '<div class="c_red font_1_2 m_tb_1">Votre commentaire est vide</div>'; 
            }
        
            if($error === ''){
                $insertComment = $pdo->prepare("INSERT INTO comment (id_picture, author, content) VALUES (:id_picture, :author, :content)");
                $insertComment->bindValue(':id_picture', $id_picture);
                $insertComment->bindValue(':author', $author);
                $insertComment->bindValue(':content', $content);
                $insertComment->execute();

            }
        }
    }
    ?>
    <!-- Page display -->
    <div class="flex column align_center m_t_2 h_100">
        
        <?php
        if (!isset($_GET['id_picture'])) {
            header('Location:index.php');
        } 
        else {
            $currentPictureId = $_GET['id_picture'];

            // Fetch the current picture and save its id_theme
            $reqPicture = $pdo->prepare("SELECT * FROM picture WHERE id_picture = :currentPictureId");
            $reqPicture->bindParam(':currentPictureId', $currentPictureId);
            $reqPicture->execute();
            $currentPicture = $reqPicture->fetch(PDO::FETCH_ASSOC);
            $idTheme = $currentPicture['id_theme'];

            // Fetch the previous picture
            $reqPrevPicture = $pdo->prepare("SELECT * FROM picture WHERE id_theme = :idTheme AND id_picture < :currentPictureId ORDER BY id_picture DESC LIMIT 1");
            $reqPrevPicture->bindParam(':idTheme', $idTheme);
            $reqPrevPicture->bindParam(':currentPictureId', $currentPictureId);
            $reqPrevPicture->execute();
            $prevPicture = $reqPrevPicture->fetch(PDO::FETCH_ASSOC);

            // Fetch the next picture
            $reqNextPicture = $pdo->prepare("SELECT * FROM picture WHERE id_theme = :idTheme AND id_picture > :currentPictureId ORDER BY id_picture ASC LIMIT 1");
            $reqNextPicture->bindParam(':idTheme', $idTheme);
            $reqNextPicture->bindParam(':currentPictureId', $currentPictureId);
            $reqNextPicture->execute();
            $nextPicture = $reqNextPicture->fetch(PDO::FETCH_ASSOC);
            
            // previous picture arrow management
            if($prevPicture){
                echo '<a class="absolute top_50 left_5" href="picture.php?id_picture='.$prevPicture['id_picture']. '"><p class="arrow left"></p></a>';
            }        

            // current picture display
            echo '<img class="w_auto h_80vh max_w_100 m_t_2 border_05_black" src="' . $currentPicture['link'] . '" width="200px">';

            // Picture title
            if($currentPicture['title'] != ''){
            echo '<p class="font_1_2 bold w_auto m_t_1 text_center p_b_1">' . $currentPicture['title'] . '</p>';
            }
           
            // next picture arrow management
            if($nextPicture){
                    echo '<a class="absolute top_50 right_5" href="picture.php?id_picture='.$nextPicture['id_picture']. '"><p class="arrow right"></p></a>';
            }

            // picture description
            echo '
            <p class="m_tb_2 font_1_2">' . $currentPicture['description'] . '</p>'.$error;

            // go back button 
            echo '<a class="close_button absolute top_80 right_4" href="theme.php?id_theme='.$idTheme.'">&#10005;</a>';
            echo '</div>';
            var_dump($idTheme);
        }
        
    // Fetch comments and comments data
    $reqComments = $pdo->prepare("SELECT * FROM comment WHERE id_picture = :currentPictureId ORDER BY created_at DESC");
    $reqComments->bindParam(':currentPictureId', $currentPictureId);
    $reqComments->execute();
    $comments = $reqComments->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="flex column align_center m_b_2">';

        
    // Display Comments
        
        echo '<div class="w_50 flex column">

        <h3 class="m_b_1 self_center">'.$reqComments->rowCount().' commentaires</h3>';

        foreach ($comments as $key => $comment){
            // Display comment's author and created time
            echo '<div class="flex column m_b_05 m_t_1">
            <p><span class="bold">' . $comment['author'] . '</span> le ' . DateTime::createFromFormat('Y-m-d H:i:s', $comment['created_at'])->format('d/m/Y \à H:i') . '</p>';
            // comment edit form
            if(isset($_GET['action']) && $_GET['action'] == 'edit' && $comment['id_comment'] == $_GET['id_comment']){
                echo '<form class="flex column" action="" method="POST"> 

                <textarea class="p_1" name="content" id="content" cols="30" rows="8">'.$comment['content'].'</textarea>

                <button class="self_center m_tb_2" type="submit">
                    Modifier
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                </form>';
            }
            // Comment text
            else {
                echo '<p>'.$comment['content'].'</p>';
            }
            echo '<div>';
            // comment edit link
            if(userConnected() && $comment['author'] == $_SESSION['membre']['nickname']) {
                echo '
                    <a class="decoration_none" href="picture.php?id_picture='.$currentPictureId.'&action=edit&id_comment='.$comment['id_comment'].'">🖊️</a>';
            }
            // comment delete link
            if (userConnected() && $comment['author'] == $_SESSION['membre']['nickname'] || userIsAdmin()) {
                echo '<a class="decoration_none" href="picture.php?id_picture='.$currentPictureId.'&action=delete&id_comment='.$comment['id_comment'].'" onclick="return confirmDelete();">🚮</a>';
            }
            echo '</div></div>';
        }
     
     // Add a comment       
     if(!isset($_GET['action'])){
        if(userConnected()){
            echo '<form class="flex column w_50 self_center" action="" method="POST"> 

                <textarea class="p_1" name="content" id="content" cols="30" rows="8" placeholder="Ajouter un commentaire"></textarea>

                <button class="self_center m_tb_2" type="submit">
                    Ajouter
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

            </form>';
        }
        else{  
            echo '<p class="m_b_2"><a class="decoration_none c_black bold" href="connexion.php">Connectez-vous</a> pour ajouter un commentaire</p>';           
        }
    }
    echo '</div>';
    require_once('./inc/bottomPage.inc.php');
    ?>

