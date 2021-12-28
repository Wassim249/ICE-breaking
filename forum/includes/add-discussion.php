<?php

include '../../includes/connection.php';
include '../../includes/modals/user.php' ;
session_start() ;
$currentUser = unserialize($_SESSION['currentUser']);


$members= isset($_POST['members']) ?  $_POST['members'] : array();
$title = $_POST['title'] ;

if($title == "") {
echo "<div class='failed' >
<i class='fas fa-exclamation-square info-icon'></i>
<div class='text'>Veuillez saisir un titre</div>
<div id='close-icon'>&times</div>
</div>";
}
else {
$con = getConnection();

    $req = $con->prepare('INSERT INTO discussion VALUES(NULL,?,?,?)');
    $req->execute(array($title,date_format(new DateTime(),"Y/m/d H:i:s"),$currentUser->id)) ;

    foreach($members as $member) {
        $idDiscussion = $con->lastInsertId() ;
       $req = getConnection()->prepare('INSERT INTO userDiscussion VALUES(?,?,?)');
    $req->execute(array($member,$idDiscussion,date_format(new DateTime(),"Y/m/d H:i:s"))) ;

    }
    echo "<div class='success' >
    <i class='fas fa-exclamation-square info-icon'></i>
    <div class='text'>Discussion ajouté avec succés</div>
    <div id='close-icon'>&times</div>
    </div>";
}
?>