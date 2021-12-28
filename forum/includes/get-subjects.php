<?php 
    include '../../includes/connection.php';
    include '../../includes/modals/user.php';

    session_start() ;
    $currentUser = unserialize($_SESSION['currentUser']) ;

  
    if($_POST['allsubjects'] == 'y') 
        $query = 'SELECT u.id as userId , u.nom , u.prenom  ,u.email , u.photo , s.id as subjectID ,s.titre , s.description , s.dateCreation 
        FROM users u , sujet s 
        WHERE u.id = s.idCreator ORDER BY s.dateCreation DESC' ;
    else
        $query = 'SELECT u.id as userId ,u.nom , u.prenom  ,u.email , u.photo ,s.id as subjectID ,s.titre , s.description , s.dateCreation 
        FROM users u , sujet s 
        WHERE u.id = s.idCreator AND idCreator = ? ORDER BY s.dateCreation DESC' ;

    $req = getConnection()->prepare($query);

    if($_POST['allsubjects']== 'y') 
        $req->execute();
    else
        $req->execute(array($currentUser->id));

   while($post = $req->fetch()) {
        $postcount = getConnection()->prepare('SELECT COUNT(*) as postcount FROM poste WHERE idSujet = ?');
        $postcount->execute(array($post['subjectID'])) ;
        $postcountResult = $postcount->fetch() ;

       echo '<div class="topic">
       <h1> <a href="subject-detail.php?id=' . $post['subjectID'] .'"> '. $post['titre'] .'</a></h1>
       <p> ' . $post['description'] .'</p>

       <hr />
       <div class="info">
         <div class="poster">
           <img src="' .  ($post['photo'] == "" ? "../images/default-profile-image.png" : "../images/" . $post['photo'])  .'" alt="" />
           <span>Posté par : &nbsp</span>
           <a href="./profile.php?id=' . $post['userId'] .'" id="poster">' . $post['nom'] . ' ' . $post['prenom'] .' </a>
           <span> &nbsp;&nbsp; | &nbsp;&nbsp;' . get_time_difference($post['dateCreation']) .'</span>
         </div>
         <span id="comments"><i class="far fa-comments-alt"></i>' . $postcountResult['postcount'] . '</span>
       </div>
     </div>' ;
   }


