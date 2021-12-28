<?php

include '../../includes/connection.php';
include '../../includes/modals/user.php' ;
session_start() ;
$currentUser = unserialize($_SESSION['currentUser']);


$members= isset($_POST['members']) ?  $_POST['members'] : array();
$title = $_POST['title'] ;
$description = $_POST['description'] ;

if($title == "") {
echo "<div class='failed' >
<i class='fas fa-exclamation-square info-icon'></i>
<div class='text'>Veuillez saisir un titre</div>
<div id='close-icon'>&times</div>
</div>";
}else if (trim( $description) == ""){
    echo "<div class='failed' >
    <i class='fas fa-exclamation-square info-icon'></i>
    <div class='text'>Veuillez saisir une description</div>
    <div id='close-icon'>&times</div>
    </div>";
}

else {
$con = getConnection();

    $req = $con->prepare('INSERT INTO sujet VALUES(NULL,?,?,?,?)');
    $req->execute(array($title,$description,date_format(new DateTime(),"Y/m/d H:i:s"),$currentUser->id)) ;

    foreach($members as $member) {
        $idSujet = $con->lastInsertId() ;
       $req = getConnection()->prepare('INSERT INTO usersujet VALUES(?,?,?)');
    $req->execute(array($member,date_format(new DateTime(),"Y/m/d H:i:s"),$idSujet)) ;

    }
    echo "<div class='success' >
    <i class='fas fa-exclamation-square info-icon'></i>
    <div class='text'>Sujet ajoutés avec succés</div>
    <div id='close-icon'>&times</div>
    </div>";
}
?>