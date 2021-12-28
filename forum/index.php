<?php
include '../includes/modals/user.php';

session_start();
if (isset($_SESSION['currentUser']))
  $currentUser = unserialize($_SESSION['currentUser']);
else
  header('Location: ../login.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ICE BREAKING | Acceuil</title>
  <link rel="stylesheet" href="./css/main.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="./css/index.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <script src="./js/main.js"></script>
  <script src="//code.tidio.co/lf2zoxxvg8n9kzfqykb21xczwpmijivb.js" async></script>
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
        if($currentUser->image == '')
          $img = 'default-profile-image.png' ;
        else 
          $img =$currentUser->image;
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
      <span>MENU</span>
      <div class="menu-item active" id="menu-new">
        <i class="fas fa-chart-network" style="color : var(--primary)"></i>
        <h4>Nouveau</h4>
      </div>
      <div class="menu-item" id="menu-mySubjects">
        <i class="fas fa-bullseye-pointer" style="color: var(--secondary)"></i>
        <h4>Mes sujets</h4>
      </div>

      <div class="menu-item" id="menu-discussions">
        <i class="far fa-comments-alt" style="color: rgb(19, 202, 19)"></i>
        <h4>Les discussions</h4>
      </div>

      <div class="menu-item" id="menu-myDiscussions">
        <i class="far fa-comments-alt" style="color: rgb(19, 202, 19)"></i>
        <h4>Mes discussions</h4>
      </div>

      <div class="menu-item" id="add-discussion">
        + ajouter une discussion
      </div>

      <div class="menu-item" id="add-subject">+ ajouter un sujet</div>
    </div>
    <div class="topics">
    </div>
  </section>
  <script>
    $(document).ready(() => {
      $('.logo').click(e=>window.location.href = './index.php')
      $(window).on("scroll", function() {
        if ($(window).scrollTop() > 50) {
          $("header").addClass("active");
        } else {
          $("header").removeClass("active");
        }
      });

      $('#add-subject').click(e=> window.location.href ='./add-subject.php') 
      $('#add-discussion').click(e=> window.location.href ='./add-discussion.php') 

      const fillSubjects = (s) => {
        !s ? console.log('clicked ' + s) : console.log('nop');
        $('.topics').empty()
        $('.topics').load(
          'includes/get-subjects.php', {
            allsubjects: s ? 'y' : 'n'
          },
          (response) => {
            if (response == 'no-subjects') {
              console.trace('add image later')
            }
          }
        )
      }
      fillSubjects(true)

      const fillDiscussions = (d) => {
        $('.topics').empty()
        $('.topics').load(
          'includes/get-discussions.php', {
            alldiscussions: d ? 'y' : 'n'
          },
          (response) => {
            if (response == 'no-subjects') {
              console.trace('add image later')
            }
          }
        )
      }

      $('#menu-new').click(() => {
        $('#menu-mySubjects').removeClass('active')
        $('#menu-discussions').removeClass('active')
        $('#menu-myDiscussions').removeClass('active')
        $('#menu-new').addClass('active')
        fillSubjects(true)
      })
      $('#menu-mySubjects').click(() => {
        $('#menu-new').removeClass('active')
        $('#menu-discussions').removeClass('active')
        $('#menu-myDiscussions').removeClass('active')
        $('#menu-mySubjects').addClass('active')
        fillSubjects(false)
      } )
      $('#menu-discussions').click(() => {
        $('#menu-new').removeClass('active')
        $('#menu-mySubjects').removeClass('active')
        $('#menu-myDiscussions').removeClass('active')
        $('#menu-discussions').addClass('active')
        fillDiscussions(true)
      } )
      $('#menu-myDiscussions').click(() => {
        $('#menu-mySubjects').removeClass('active')
        $('#menu-discussions').removeClass('active')
        $('#menu-new').removeClass('active')
        $('#menu-myDiscussions').addClass('active')
        fillDiscussions(false)
      } )

      const fillSearch =(value,type) => {
    $('.search-items').load('includes/search.php', {
      val : value ,
      type : type
    })
  }

  $('#search-input').keyup(e=> {
    if( $('#search-input').val() == '')  $('.search-result').css('display','none')
    else {
      $('.search-result').css('display','block')
      fillSearch($('#search-input').val(),$('#cmb-sujet-discussion').val())
    }
  })
    })
  </script>
</body>

</html>