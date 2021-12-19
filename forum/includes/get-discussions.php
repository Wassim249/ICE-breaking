<?php 
    include '../../includes/connection.php';
    include '../../includes/modals/user.php';

    function get_time_difference($created_time)
    {
           $str = strtotime($created_time);
           $today = strtotime(date('Y-m-d H:i:s'));
   
           // It returns the time difference in Secondd...
           $time_differnce = $today-$str;
   
           // To Calculate the time difference in Yeard...
           $years = 60*60*24*365;
   
           // To Calculate the time difference in Monthd...
           $months = 60*60*24*30;
   
           // To Calculate the time difference in Dayd...
           $days = 60*60*24;
   
           // To Calculate the time difference in Hourd...
           $hours = 60*60;
   
           // To Calculate the time difference in Minuted...
           $minutes = 60;
   
           if(intval($time_differnce/$years) > 1)
           {
               return 'il y a ' . intval($time_differnce/$years)." années";
           }else if(intval($time_differnce/$years) > 0)
           {
               return 'il y a ' . intval($time_differnce/$years)." an";
           }else if(intval($time_differnce/$months) > 1)
           {
               return 'il y a ' . intval($time_differnce/$months)." mois";
           }else if(intval(($time_differnce/$months)) > 0)
           {
               return 'il y a ' . intval(($time_differnce/$months))." mois";
           }else if(intval(($time_differnce/$days)) > 1)
           {
               return 'il y a ' . intval(($time_differnce/$days))." jours";
           }else if (intval(($time_differnce/$days)) > 0) 
           {
               return 'il y a ' . intval(($time_differnce/$days))." jour";
           }else if (intval(($time_differnce/$hours)) > 1) 
           {
               return 'il y a ' . intval(($time_differnce/$hours))." heures";
           }else if (intval(($time_differnce/$hours)) > 0) 
           {
               return 'il y a ' . intval(($time_differnce/$hours))." heure";
           }else if (intval(($time_differnce/$minutes)) > 1) 
           {
               return 'il y a ' . intval(($time_differnce/$minutes))." minutes";
           }else if (intval(($time_differnce/$minutes)) > 0) 
           {
               return 'il y a ' . intval(($time_differnce/$minutes))." minute";
           }else if (intval(($time_differnce)) > 1) 
           {
               return 'il y a ' . intval(($time_differnce))." secondes";
           }else
           {
               return "il y a quelques secondes";
           }
     }

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
               <span>Posté par : </span>
               <a href="#" id="poster">'. $post['nom'] . ' ' . $post['prenom'] .' </a>
               <span>&nbsp;&nbsp; '  . get_time_difference($post['dateCreation']) .'</span>
           </div>
           <span id="comments"><i class="far fa-comments-alt"></i>'. $msgCountResult['msgCount'] .'</span>
       </div>
   </div>' ;
   }


