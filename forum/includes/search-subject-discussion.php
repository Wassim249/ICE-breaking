<?php
     include '../../includes/connection.php';
     include '../../includes/modals/user.php';
 
     session_start() ;
     $currentUser = unserialize($_SESSION['currentUser']) ;
 

if(isset($_POST['search-discussions'])) {
    $req = getConnection()->prepare("SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , d.id as discussionID ,d.titre  , d.dateCreation 
    FROM users u , discussion d
    WHERE u.id = d.idCreator AND d.titre LIKE ?  ORDER BY d.dateCreation DESC");
    $req->execute(array('%$_POST["search-value"]%'));

    while($post = $req->fetch()) {
        $msgcount = getConnection()->prepare('SELECT COUNT(*) as msgCount FROM message WHERE iddiscussion = ?');
        $msgcount->execute(array($post['discussionID'])) ;
        $msgCountResult = $msgcount->fetch() ;

       echo ' <div class="topic">
       <h1><a href="discussion.php?id=" '. $post['discussionID'] .'>'  . $post['titre'] .'</a></h1>

       <hr>
       <div class="info">
           <div class="poster">
               <img src="' .  ($post['photo'] == "" ? "../images/default-profile-image.png" : "../images/" . $post['photo'])  .'" alt="">
               <span>Posté par : </span>
               <a href="#" id="poster">'. $post['nom'] . ' ' . $post['prenom'] .' </a>
               <span>&nbsp;&nbsp; '  . get_time_difference($post['dateCreation']) .'</span>
           </div>
           <span id="comments"><i class="far fa-comments-alt"></i>'. $msgCountResult['msgCount'] .'</span>
       </div>
   </div>' ;
   }
}

else {
    $req = getConnection()->prepare("SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , s.id as subjectID ,s.titre , s.description , s.dateCreation 
    FROM users u , sujet s 
    WHERE u.id = s.idCreator AND s.titre LIKE ? ORDER BY s.dateCreation DESC");
    $req->execute(array('%$_POST["search-value"]%'));

    while($post = $req->fetch()) {
        $postcount = getConnection()->prepare('SELECT COUNT(*) as postcount FROM poste WHERE idSujet = ?');
        $postcount->execute(array($post['subjectID'])) ;
        $postcountResult = $postcount->fetch() ;

       echo '<div class="topic">
       ' .  ($_POST['allsubjects'] ===  true ? '1' : '0') .'
       <h1> <a href="../subject.php?id=' . $post['subjectID'] .'"> '. $post['titre'] .'</a></h1>
       <p> ' . $post['description'] .'</p>

       <hr />
       <div class="info">
         <div class="poster">
           <img src="' .  ($post['photo'] == "" ? "../images/default-profile-image.png" : "../images/" . $post['photo'])  .'" alt="" />
           <span>Posté par : </span>
           <a href="../profile.php?id=' . $post['userId'] .'" id="poster">' . $post['nom'] . ' ' . $post['prenom'] .' </a>
           <span> ' . get_time_difference($post['dateCreation']) .'</span>
         </div>
         <span id="comments"><i class="far fa-comments-alt"></i>' . $postcountResult['postcount'] . '</span>
       </div>
     </div>' ;
   }
}