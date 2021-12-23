<?php

include '../../includes/modals/user.php';
include '../../includes/connection.php';

$type = $_POST['type'] ;
$id = $_POST['id'] ;

if($type == 'd') {
    $req = getConnection()->prepare('SELECT u.id , u.nom , u.prenom , u.photo FROM users u ,userDiscussion ud WHERE ud.idDiscussion= ? AND u.id = ud.idUser ');
    $req->execute(array($id));

    while($discussion = $req->fetch()) {
        $img = '' ;
        if($discussion['photo'] != null) $img = $discussion['photo'] ;
        else $img = "default-profile-image.png" ;
        echo ' <div class="member"> 
        <img src="../images/' . $img.  '" alt="">
        <a href="profile.php?id=' . $discussion['id'] .'">'. $discussion['nom'] . ' ' . $discussion['prenom'] .'</a>
      </div>' ;
    
    }

  
}  else if ($type == 's') {

    $req = getConnection()->prepare('SELECT u.id , u.nom , u.prenom , u.photo FROM users u ,usersujet us WHERE us.idSujet= ? AND u.id = us.idUser ');
    $req->execute(array($id));
    while($subject = $req->fetch()) {
        $img = '' ;
        if($subject['photo'] != null) $img = $subject['photo'] ;
        else $img = "default-profile-image.png" ;
        echo ' <div class="member"> 
        <img src="../images/' . $img.  '" alt="">
        <a href="profile.php?id=' . $subject['id'] .'">'. $subject['nom'] . ' ' . $subject['prenom'] .'</a>
      </div>' ;
    }
}

?>