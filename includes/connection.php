<?php
//focntion retourne un objet de connexion PDO 
    function getConnection() {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=ice-breaking;charset=utf8',
            'root', '');
            return $bdd ;
        } catch (Exception $e) {
           return null ;
        }
    }
// fonction retourne true si l'utilisateur donné en parametre est un membre dans la discussion donnée en parametre
    function isMemberDiscussion($idUser,$idDiscussion) {
        $req = getConnection()->prepare("SELECT COUNT(*) as 'rowsCount' FROM userdiscussion WHERE idUser = ? AND idDiscussion= ?");
        $req->execute(array($idUser,$idDiscussion)) ;
        $row = $req->fetch() ;
        $userDiscussion = $row['rowsCount'];
    
        $req = getConnection()->prepare("SELECT COUNT(*) as 'rowsCount' FROM discussion WHERE idCreator = ? AND id= ?");
        $req->execute(array($idUser,$idDiscussion)) ;
        $row = $req->fetch() ;
        $discussion = $row['rowsCount'] ;

        if($discussion > 0 || $userDiscussion > 0) return true ;
        else return false;
    }
// fonction retourne true si l'utilisateur donné en parametre est un membre dans le sujet donnée en parametre
    function isMemberSujet($idUser,$idSujet) {
        $req = getConnection()->prepare("SELECT COUNT(*) as 'rowsCount' FROM usersujet WHERE idUser = ? AND idsujet= ?");
        $req->execute(array($idUser,$idSujet)) ;
        $row = $req->fetch() ;
        $userSujet = $row['rowsCount'] ;

        $req = getConnection()->prepare("SELECT COUNT(*) as 'rowsCount' FROM sujet WHERE idCreator = ? AND id= ?");
        $req->execute(array($idUser,$idSujet)) ;
        $row = $req->fetch() ;
        $sujet = $row['rowsCount'] ;

        if($sujet > 0 || $userSujet > 0) return true ;
        else return false;    
    }

    //fonction qui calcule le décalage horaire entre la date courante et une date donné en parametre
    function get_time_difference($created_time) {
           $str = strtotime($created_time);
           $today = strtotime(date('Y-m-d H:i:s'));
   
          // Il renvoie la différence de temps en secondes...
           $time_differnce = $today-$str;
   
           // Pour calculer le décalage horaire en années...
           $years = 60*60*24*365;
   
           // Pour calculer le décalage horaire en mois...
           $months = 60*60*24*30;
   
          // Pour calculer le décalage horaire en jours...
           $days = 60*60*24;
   
        // Pour calculer le décalage horaire en Heures...
           $hours = 60*60;
   
        // Pour calculer le décalage horaire en Minutes...
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
