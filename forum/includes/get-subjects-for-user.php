<?php
    include '../../includes/connection.php';
    include '../../includes/modals/user.php' ;
    session_start() ;
    $currentUser = unserialize($_SESSION['currentUser']);


  

    if(!isset($_POST['userId'])) $userId = $currentUser->id ;
    else $userId = $_POST['userId'] ;

    $req = getConnection()->prepare('SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , s.id as subjectID ,s.titre , s.description , s.dateCreation 
    FROM users u , sujet s WHERE u.id = s.idCreator AND u.id = ? ORDER BY s.dateCreation DESC');
    $req->execute(array($userId)) ;

    while($subject = $req->fetch()) {
        $postcount = getConnection()->prepare('SELECT COUNT(*) as postcount FROM poste WHERE idSujet = ?');
        $postcount->execute(array($subject['subjectID'])) ;
        $postcountResult = $postcount->fetch() ;


       if(isset($subject['photo'])) $image =$subject['photo'] ;
        else  $image =  'default-profile-image.png' ;

 
        echo ' <div class="topic">
        <h1>'. $subject['titre'] .'</h1>
        <p>'. $subject['description'] .'</p>
        <hr />
        <div class="info">
          <div class="poster">
            <img src="../images/'. $image .'" alt="" />
            <span>Posté par : </span>
            <a href="profile.php?id='. $subject['userId'] .'" id="poster">'. $subject['nom'] . ' ' . $subject['prenom'] .'</a>
            <span> '. get_time_difference($subject['dateCreation']) .'</span>
          </div>
          <span id="comments"><i class="far fa-comments-alt"></i>'. $postcountResult['postcount'] .'</span>
        </div>
      </div>' ;
    }
?>