<?php


include '../../includes/connection.php';
include '../../includes/modals/user.php';

$value = $_POST['val'] ;
$type = $_POST['type'] ;

if($type == 's') $table = 'sujet' ;
else $table ='discussion'  ;

$req = getConnection()->prepare("SELECT id, titre FROM " . $table . " WHERE titre LIKE ?");
$req->execute(array($value .'%'));

while($res = $req->fetch()) {
 echo '<a href="'. ($type == 's' ? 'subject-detail.php?id=' : 'discussion-detail.php?id=')  . $res['id'] .'">'. $res['titre'] .'</a>' ;
}
?>