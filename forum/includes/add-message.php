<?php
include '../../includes/connection.php';
include '../../includes/modals/user.php' ;
session_start() ;
$currentUser = unserialize($_SESSION['currentUser']);

$desc = $_POST['desc'] ;
$id = $_POST['id'] ;
if($desc != "") {
    $req = getConnection()->prepare('INSERT INTO message VALUES(NULL,?,?,?,?)');
    $req->execute(array($id,$currentUser->id,$desc,date_format(new DateTime(),"Y/m/d H:i:s")));
    header('Location: ../subject-detail.php?id='.$id) ;
}
?>