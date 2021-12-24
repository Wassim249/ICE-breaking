<?php
    include '../../includes/connection.php';
    include '../../includes/modals/user.php' ;
    session_start() ;
    $currentUser = unserialize($_SESSION['currentUser']);
   
    if(!isset($_POST['userId'])) $userId = $currentUser->id ;
    else $userId = $_POST['userId'] ;

    $req = getConnection()->prepare('SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , s.id as discussionID ,s.titre  , s.dateCreation 
    FROM users u , discussion s WHERE u.id = s.idCreator AND u.id = ? ORDER BY s.dateCreation DESC');
    $req->execute(array($userId)) ;

    while($discussion = $req->fetch()) {
        $postcount = getConnection()->prepare('SELECT COUNT(*) as postcount FROM message WHERE iddiscussion = ?');
        $postcount->execute(array($discussion['discussionID'])) ;
        $postcountResult = $postcount->fetch() ;


       if(isset($discussion['photo'])) $image =$discussion['photo'] ;
        else  $image =  'default-profile-image.png' ;

 
        echo '  <div class="discussion">
        <h1>'. $discussion['titre'] .'</h1>
        <hr />
        <div class="info">
          <div class="poster">
            <img src="../images/'. $image .'" alt="" />
            <span>Posté par : </span>
            <a href="#" id="poster">'. $discussion['nom'] . ' ' . $discussion['prenom'] .' </a>
            <span>&nbsp;&nbsp; '. get_time_difference($discussion['dateCreation']) .'</span>
          </div>
          <span id="comments"><i class="far fa-comments-alt"></i>'. $postcountResult['postcount'] .'</span>
        </div>
      </div>' ;
    }
?>