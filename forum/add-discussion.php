<?php
include '../includes/modals/user.php';

session_start();
if (isset($_SESSION['currentUser']))
    $currentUser = unserialize($_SESSION['currentUser']);
else
    header('Location: ../login.php');
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/main.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="./css/add-subject.css?v=<?php echo time(); ?>" />
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
        <img src="<?php echo "./../images/" . $currentUser->image; ?>" alt="profile" />
        <span><?php echo $currentUser->firstName . ' ' . $currentUser->lastName;  ?></span>
      </div>
    </nav>

    <div class="search-result">
      <div class="search-items">
      </div>
    </div>
    </header>

    <section class="home">

    <div class="inputs">
    <h1>Ajouter une discussion :</h1>

<form action="" class="form">
    <div class="message">

    </div>
    <div class="title">
        <label for="">Titre du discussion :</label>
        <input type="text" name="" id="discussionTitle">
    </div>
    <div class="members">
        <label for="">Ajouter des membres</label>
        <br>
        <div class="search-members">
            <input type="text" placeholder="Rechercher des utilisateurs" id="searchMembersInput">
            <div class="founded-members">
            </div>
        </div>
        <div class="added-members">
        </div>
        <input type="submit" value="Ajouter">
    </div>


</form>
    </div>

    <div class="img-container">
        <img src="../images/discussion.jpg" alt="">
    </div>
     
    </section>

    <script>
        document.querySelector('.search-members').addEventListener('keyup', e => {
            document.querySelector('.founded-members').style.display = 'flex'
            if (document.querySelector('.search-members').value == "")
                document.querySelector('.founded-members').style.display = 'none'

        })

        $(document).ready(() => {
            const fillMembers = (value) => {
                $('.founded-members').load('includes/get-users.php', {
                    val: value
                })
            }
            document.querySelector('.search-members').addEventListener('keyup', e => {
                fillMembers($('#searchMembersInput').val())
                document.querySelector('.founded-members').style.display = 'flex'
                if ($('#searchMembersInput').val() == "")
                    document.querySelector('.founded-members').style.display = 'none'
            })

            let addedMembers = []
            $(document).on("click", '.userSearched', (e) => {
                console.log(e.target.id)

                if (addedMembers.find((val) => val == e.target.id) == undefined) {
                    var divContainer = document.createElement('div')
                    divContainer.className = 'added-member'
                    divContainer.id = 'added-' + e.target.id

                    var span1 = document.createElement('span')
                    span1.textContent = e.target.textContent

                    var span2 = document.createElement('span')
                    span2.innerHTML = "*"
                    span2.className = "delete-added-member"

                    divContainer.appendChild(span1)
                    divContainer.appendChild(span2)
                    addedMembers.push(e.target.id)

                    $('.added-members').append(divContainer)
                }
            })

            $(document).on("click", '.delete-added-member', (e) => {
                console.log('fdgfd');
                $(this).closest('added-member').remove()
            })

            $('.form').submit((e) => {
                e.preventDefault()
                $('.message').load('includes/add-discussion.php', {
                    title: $('#discussionTitle').val(),

                    members: addedMembers
                }, (res) => {
                    $('#subjectTitle').val("")
                    $('#searchMembersInput').val("")
                    $('founded-members').style.display = 'none'
                })
            })

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