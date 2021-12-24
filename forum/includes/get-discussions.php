<?php 
    include '../../includes/connection.php';
    include '../../includes/modals/user.php';


    session_start() ;
    $currentUser = unserialize($_SESSION['currentUser']) ;

  
    if($_POST['alldiscussions'] == 'y') 
        $query = 'SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , d.id as discussionID ,d.titre  , d.dateCreation 
        FROM users u , discussion d
        WHERE u.id = d.idCreator  ORDER BY d.dateCreation DESC' ;
    else
    $query = 'SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , d.id as discussionID ,d.titre  , d.dateCreation 
    FROM users u , discussion d
    WHERE u.id = d.idCreator AND idCreator = ?  ORDER BY d.dateCreation DESC' ;

    $req = getConnection()->prepare($query);

    if($_POST['alldiscussions']== 'y') 
        $req->execute();
    else
        $req->execute(array($currentUser->id));

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
               <span>Posté par : &nbsp;</span>
               <a href="#" id="poster">'. $post['nom'] . ' ' . $post['prenom'] .' </a>
               <span>&nbsp;&nbsp; |&nbsp;&nbsp;'  . get_time_difference($post['dateCreation']) .'</span>
           </div>
           <span id="comments"><i class="far fa-comments-alt"></i>'. $msgCountResult['msgCount'] .'</span>
       </div>
   </div>' ;
   }


