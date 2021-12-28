<?php
     include '../../includes/connection.php' ;
     include '../../includes/modals/user.php' ;
     session_start() ;
     $currentUser = unserialize($_SESSION['currentUser']);
     
     $picture = $_FILES['pictureFile'] ;
     if(isset($picture)) {
       
        $ext = pathinfo($_FILES['pictureFile']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["pictureFile"]["tmp_name"], "../../images/" . $currentUser->id .'.' . $ext);

        $currentUser->set_image( $currentUser->id .'.' . $ext) ;

        $req = getConnection()->prepare('UPDATE users SET photo = ? WHERE id = ?');
        $req->execute(array($currentUser->id .'.' . $ext,$currentUser->id));
        $_SESSION['currentUser'] = serialize($currentUser) ;
        echo 'done' ;
     }
?>