<?php
session_start() ;
  unset($_SESSION['currentUser']) ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
    <header class="header">
        <nav>
          <div class="logo">ICE BREAKING</div>
          <div class="links">
            <ul class="link-list">
              <li class="link-items"><a href="./index.php" id="active">Acceuil</a></li>
              <li class="link-items"><a href="./forum/index.php">Forum</a></li>
              <li class="link-items"><a href="./index.php">A propos</a></li>
            </ul>
          </div>

          <div class="btns">
            <button id="loginBtn" onclick="
              window.location.href = './login.php'
            ">S'identifier</button>
            <button id="registerBtn" onclick="
             window.location.href = './register.php'
            ">S'inscrire</button>
          </div>
        </nav>
    </header>

    <section class="main">
      <div class="first-section">
        <h1 class="title1">
          Bonjour, que pouvons-nous vous aider à trouver ?
        </h1>
        <h5 class="title2">
          ICE breaking est une platforme de forum
        </h5>

        <form action="" class="search-form">
          <input type="search" name="" id="search-value" placeholder="Rechercher un sujet...">
          <input type="submit" value="Rechercher" id= "submit-search">
        </form>
      </div>
    </section>

    <footer class="footer">
        <p>Developpé par: <a href="#">Wassim EL BAKKOURI</a></p>
    </footer>

    <script>
      $(window).on("scroll", function() {
    if($(window).scrollTop() > 50) {
        $(".header").addClass("active-header");
    } else {
        //remove the background property so it comes transparent again (defined in your css)
       $(".header").removeClass("active-header");
    }
});
    </script>
</body>
</html>