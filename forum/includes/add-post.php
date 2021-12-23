<?php


include '../../includes/connection.php';
include '../../includes/modals/user.php' ;
session_start() ;
$currentUser = unserialize($_SESSION['currentUser']);

$desc = $_POST['desc'] ;
$id = $_POST['id'] ;
if($desc != "") {
    $req = getConnection()->prepare('INSERT INTO poste VALUES(NULL,?,?,?,?)');
    $req->execute(array($id,$currentUser->id,date_format(new DateTime(),"Y/m/d H:i:s"),$desc));
    header('Location: ../subject-detail.php?id='.$id) ;
}




?>