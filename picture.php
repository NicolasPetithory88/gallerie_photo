<?php
require_once('./inc/header.inc.php');
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

        if($comment && $comment['author'] == $_SESSION['membre']['nickname']) {
            $pdo->query("DELETE FROM comment WHERE id_comment = '$id_comment'");
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
                $pdo->query("UPDATE comment SET content = '$content' WHERE id_comment = '$id_comment'");
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

<div class="flex column align_center m_tb_2 flex_1">
    <!-- Page display -->
    <?php
    if (!isset($_GET['id_picture'])) {
        header('Location:index.php');
    } 
    else {
        $currentPictureId = $_GET['id_picture'];

        // Fetch the current picture and save its id_theme
        $reqPicture = $pdo->query("SELECT * FROM picture WHERE id_picture = '$currentPictureId'");
        $currentPicture = $reqPicture->fetch(PDO::FETCH_ASSOC);
        $idTheme = $currentPicture['id_theme'];

        // Fetch the previous and next picture
        $reqPrevPicture = $pdo->query("SELECT * FROM picture WHERE id_theme = '$idTheme' AND id_picture < '$currentPictureId' ORDER BY id_picture DESC LIMIT 1");
        $prevPicture = $reqPrevPicture->fetch(PDO::FETCH_ASSOC);

        $reqNextPicture = $pdo->query("SELECT * FROM picture WHERE id_theme = '$idTheme' AND id_picture > '$currentPictureId' ORDER BY id_picture ASC LIMIT 1");
        $nextPicture = $reqNextPicture->fetch(PDO::FETCH_ASSOC);
        
        // previous picture arrow management
        if($prevPicture){
            echo '<a class="absolute top_50 left_5" href="picture.php?id_picture='.$prevPicture['id_picture']. '"><p class="arrow left"></p></a>';
        }

        // current picture display
        echo '<img class="w_50 h_auto m_tb_2" src="' . $currentPicture['link'] . '" width="200px">';

        // Picture title
        echo '<h1>' . $currentPicture['title'] . '</h1>';
        // next picture arrow management
        if($nextPicture){
                echo '<a class="absolute top_50 right_5" href="picture.php?id_picture='.$nextPicture['id_picture']. '"><p class="arrow right"></p></a>';
            }

        // picture description
        echo '
        <p class="m_tb_2 font_1_2">' . $currentPicture['description'] . '</p>'.$error;
        
    }
    
// Add a comment    
    if(userConnected()){

    echo '<form class="flex column w_50" action="" method="POST"> 

        <textarea name="content" id="content" cols="30" rows="8" placeholder="&nbsp;Ajoutez un commentaire"></textarea>

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
        echo '<p class="m_b_2">Connectez-vous pour ajouter un commentaire</p>';
    }

// Display Comments
    // Fetch comments and comments data
    $reqComments = $pdo->query("SELECT * FROM comment WHERE id_picture = '$currentPictureId' ORDER BY created_at DESC ");
    $comments = $reqComments->fetchAll(PDO::FETCH_ASSOC);
    echo '<div class="w_50 flex column">

    <h3 class="m_b_1 self_center">'.$reqComments->rowCount().' commentaires</h3>';

    foreach ($comments as $key => $comment){
        // Display comment's author and created time
        echo '<div class="flex column m_b_05 m_t_1">
        <p><span class="bold">' . $comment['author'] . '</span> le ' . DateTime::createFromFormat('Y-m-d H:i:s', $comment['created_at'])->format('d/m/Y \à H:i') . '</p>';
        // comment edit form
        if(isset($_GET['action']) && $_GET['action'] == 'edit' && $comment['id_comment'] == $_GET['id_comment']){
            echo '<form class="flex column" action="" method="POST"> 

            <textarea name="content" id="content" cols="30" rows="8">'.$comment['content'].'</textarea>

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
        // comment delete lm*ink
        if (userConnected() && $comment['author'] == $_SESSION['membre']['nickname'] || userIsAdmin()) {
            echo '<a class="decoration_none" href="picture.php?id_picture='.$currentPictureId.'&action=delete&id_comment='.$comment['id_comment'].'" onclick="return confirmDelete();">🚮</a>';
        }
        echo '</div></div>';
    }
    echo '</div>';

?>
    <!-- go back button -->
    <a class="close_button absolute top_80 right_4" href="theme.php?id_theme=<?=$idTheme?>">&#10005;</a>

    <!-- <a class="decoration_none c_grey m_t_2" href="theme.php?id_theme=<?=$idTheme?>">
        <button>
            Retour au thème
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </a> -->

<?php
require_once('./inc/bottomPage.inc.php');
?>

