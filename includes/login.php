<?php
include 'connection.php';
include 'modals/user.php';

$email = $_POST['email'];
$pwd = $_POST['pwd'];

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo " <div class='failed' >
    <i class='fas fa-exclamation-square info-icon'></i>
    <div class='text'>Veuillez inserer un email valide</div>
    <div id='close-icon'>&times</div>
    </div>";
} else if (empty($pwd)) {
    echo " <div class='failed'> <i class='fas fa-exclamation-square info-icon'></i>
        <div class='text'>Veuillez inserer un mot de passe</div>
        <div id='close-icon'>x</div></div>";
} else {
    $req = getConnection()->prepare('SELECT * FROM users WHERE email = ? AND mdp = ?');
    $req->execute(array($email, md5($pwd)));

    if ($req->rowCount() > 0) {
        session_start();
        $data = $req->fetch();
        $currentUser = new User($data['id'], $data['nom'], $data['prenom'], $data['email']);
        $currentUser->set_image($data['photo'] == null ? 'default-profile-image.png' : $data['photo']);
        $_SESSION['currentUser'] = serialize($currentUser);
        echo 'login-success';
    } else {
        echo "<div class='failed' >
            <i class='fas fa-exclamation-square info-icon'></i>
            <div class='text'>l'adresse email ou le mot de passe sont incorrectes</div>
            <div id='close-icon'>&times</div>
            </div>";
    }

    $req->closeCursor();
}
