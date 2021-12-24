<?php
        include 'connection.php' ;
        include 'modals/user.php' ;

        $firstName = $_POST['firstName'] ;
        $lastName = $_POST['lastName'] ;
        $email = $_POST['email'] ;
        $pwd = $_POST['pwd'] ;
        $pwdConf = $_POST['pwdConf'] ;

        if(empty($firstName)) {
            echo "<div class='failed' >
            <i class='fas fa-exclamation-square info-icon'></i>
            <div class='text'>veuillez inserrer un nom valide</div>
            <div id='close-icon'>&times</div>
            </div>" ;
        }
        else if (empty($lastName)) {
            echo "<div class='failed' >
            <i class='fas fa-exclamation-square info-icon'></i>
            <div class='text'>veuillez inserrer un prenom valide</div>
            <div id='close-icon'>&times</div>
            </div>" ;
        }

        else if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='failed' >
            <i class='fas fa-exclamation-square info-icon'></i>
            <div class='text'>Veuillez inserer un email valide</div>
            <div id='close-icon'>&times</div>
            </div>" ;
        }

        elseif (empty($pwd)) {
            echo "<div class='failed' >
            <i class='fas fa-exclamation-square info-icon'></i>
            <div class='text'>Veuillez inserer un mot de passe</div>
            <div id='close-icon'>&times</div>
            </div>" ;
        }
        else {
            $uppercase = preg_match('@[A-Z]@', $pwd);  
            $lowercase = preg_match('@[a-z]@', $pwd);
            $number    = preg_match('@[0-9]@', $pwd);
            $specialChars = preg_match('@[^\w]@', $pwd);
    
            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pwd) < 8) {
                echo "<div class='failed' >
                <i class='fas fa-exclamation-square info-icon'></i>
                <div class='text'>Le mot de passe doit comporter au moins 8 caractères et doit inclure au moins une lettre majuscule, un chiffre et un caractère spécial.</div>
                <div id='close-icon'>&times</div>
                </div>" ;
            }

            else if ($pwd != $pwdConf) {
                echo "<div class='failed' >
                <i class='fas fa-exclamation-square info-icon'></i>
                <div class='text'>Les deux mots de passe ne se correspondent pas</div>
                <div id='close-icon'>&times</div>
                </div>" ;
            }

            else {
                $req = getConnection()->prepare('SELECT * FROM users WHERE email = ?');
                $req->execute(array($email));

                if($req->rowCount() > 0) {
                    echo "<div class='failed' >
                    <i class='fas fa-exclamation-square info-icon'></i>
                    <div class='text'>Veuillez choisir un entre adresse email</div>
                    <div id='close-icon'>&times</div>
                    </div>" ;
                }
                else {
                    try {
                        $con =getConnection();
                        $req = $con->prepare('INSERT INTO users VALUES(NULL,?,?,?,?,NULL)');
                        $req->execute(array($firstName,$lastName ,$email,md5($pwd)));
                        $currentUser =  new User($con->lastInsertId(),$firstName,$lastName,$email) ;
                      
                        session_start() ;
                        $_SESSION['currentUser'] = serialize($currentUser) ;

                        echo 'register-success' ;
                    } catch (Exception $e) {
                        echo "<div class='failed' >
                        <i class='fas fa-exclamation-square info-icon'></i>
                        <div class='text'>Erreur lors d'inscription</div>
                        <div id='close-icon'>&times</div>
                        </div>" ;
                    }
                   
                }
            }
        }


?>