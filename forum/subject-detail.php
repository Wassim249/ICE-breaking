<?php
include '../includes/modals/user.php';
include '../includes/connection.php';

session_start();
if (isset($_SESSION['currentUser']))
  $currentUser = unserialize($_SESSION['currentUser']);
else
  header('Location: ../login.php');

if (!isset($_GET['id']))
  header('Location: ../login.php');


?>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="./css/main.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="./css/subject.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body>
  <header>
    <nav>
      <div class="logo">ICE BREAKING</div>
      <div class="search-bar">
        <input type="search" name="" id="search-input" placeholder="Rechercher un(e) ..." />
        <select name="" id="cmb-sujet-discussion">
          <option value="s" default>Sujet</option>
          <option value="d">Discussion</option>
        </select>
      </div>
      <div class="profile">
        <img src="<?php
                  if ($currentUser->image == '')
                    $img = 'default-profile-image.png';
                  else
                    $img = $currentUser->image;
                  echo "../images/" . $img; ?>" alt="profile" />
        <span> <a href="./profile.php"><?php echo $currentUser->firstName . ' ' . $currentUser->lastName;  ?></a></span>
      </div>
    </nav>

    <div class="search-result">
      <div class="search-items">
      </div>
    </div>
  </header>

  <section class="home">
    <div class="navigation">
      <span>Les membres : </span>
      <div class="members-list"></div>
    </div>
    <div class="topic-detail">
      <div class="topic-info">
        <h1><?php
            $req = getConnection()->prepare('SELECT titre FROM sujet WHERE id = ?');
            $req->execute(array($_GET['id']));
            $s = $req->fetch();
            echo $s['titre'];
            ?></h1>
        <div class="poster-profile">

        </div>
        <p><?php
            $req = getConnection()->prepare('SELECT description FROM sujet WHERE id = ?');
            $req->execute(array($_GET['id']));
            $s = $req->fetch();
            echo $s['description'];
            ?></p>
        <hr />
      </div>
      <div class="add-response">
        <form action="" id="submit-response-form">
          <textarea name="submitted-description" id="submitted-description" cols="50" rows="2" form="submit-response-form" required placeholder="Taper une reponse" autofocus wrap="soft"></textarea>
          <input type="submit" value="Ajouter">
        </form>
      </div>
      <div class="answers">
        <span id="answers-number"><?php
                                  $req = getConnection()->prepare('SELECT count(*) as postCount FROM sujet s , poste p WHERE p.idSujet = s.id AND s.id = ?');
                                  $req->execute(array($_GET['id']));
                                  $s = $req->fetch();
                                  echo $s['postCount'] . ' reponses';
                                  ?></span>
      </div>

      <div class="responses">
        <?php
        $req = getConnection()->prepare('SELECT u.id , u.nom , u.prenom , u.photo ,p.dateCreation ,p.description FROM poste p, sujet s ,users u WHERE s.id = ? AND s.idCreator = u.id AND p.idSujet = s.id AND p.idCreator = u.id;');
        $req->execute(array($_GET['id']));


        while ($poste = $req->fetch()) {
          $image = 'default-profile-image.png';
          if ($poste['photo'] != null) $image = $poste['photo'];

          echo '  <div class="responses-item">
                <div class="response-poster-profile">
                  <img src="../images/' . $image  . '" alt="" />
                  <span id="name">' . $poste['nom'] . ' ' . $poste['prenom'] . '</span>
                  <div class="time">
                    <span>' . get_time_difference($poste['dateCreation']) . '</span>
                  </div>
                </div>
                <p>' . $poste['description'] . '</p>
                <hr />
              </div>';
        }
        ?>

      </div>
    </div>
  </section>

  <script>
    $(document).ready(() => {
      $('.logo').click(e => window.location.href = './index.php')
      $('.members-list').load('includes/get-members.php', {
        type: 's',
        id: <?php echo $_GET['id'] ?>
      })

      $('.poster-profile').load('includes/get-creator.php', {
        type: 's',
        id: <?php echo $_GET['id'] ?>
      })

      $('#submit-response-form').submit(e => {
        e.preventDefault()
        $.ajax({
          type: 'post',
          url: 'includes/add-post.php',
          data: {
            desc: $('#submitted-description').val(),
            id: <?php echo  $_GET['id']; ?>
          },
          success: function() {

          }
        });
      })

      const fillSearch = (value, type) => {
        $('.search-items').load('includes/search.php', {
          val: value,
          type: type
        })
      }

      $('#search-input').keyup(e => {
        if ($('#search-input').val() == '') $('.search-result').css('display', 'none')
        else {
          $('.search-result').css('display', 'block')
          fillSearch($('#search-input').val(), $('#cmb-sujet-discussion').val())
        }
      })
    })
  </script>
</body>

</html>