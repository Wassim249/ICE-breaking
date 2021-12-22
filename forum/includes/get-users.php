<?php

include '../../includes/connection.php';
include '../../includes/modals/user.php' ;
session_start() ;
$currentUser = unserialize($_SESSION['currentUser']);

    if(isset($_POST['val'])) {
        $val = $_POST['val'] ;
        $req = getConnection()->prepare('SELECT * FROM users WHERE nom LIKE ? OR prenom LIKE ? ');
        $req->execute(array($val.'%',$val.'%')) ;
       while( $user = $req->fetch() ) {
           if($user['id'] != $currentUser->id)
          echo ' <span class="userSearched" id="'.$user['id'].'">'. $user['nom'] . ' ' . $user['prenom'] . '</span>' ;
       }

    }

?>