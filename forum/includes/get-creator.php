<?php
        include '../../includes/connection.php';
        include '../../includes/modals/user.php';

        session_start() ;
        $currentUser = unserialize($_SESSION['currentUser']) ;

        $type = $_POST['type'] ;
        $id = $_POST['id'] ;

        if($type == 's'){
            $req = getConnection()->prepare('SELECT u.id , u.nom , u.prenom , u.photo FROM users u ,sujet s WHERE s.id= ? AND u.id = s.idCreator;');
            $req->execute(array($id));
            while($subject = $req->fetch()) {
                $img = '' ;
                if($subject['photo'] != null) $img = $subject['photo'] ;
                else $img = "default-profile-image.png" ;
             
              echo ' <img src="../images/' . $img .'" alt="" />
              <span id="name">'. $subject['nom'] . ' ' . $subject['prenom'] .'</span> ';
             
            }
        }

?>