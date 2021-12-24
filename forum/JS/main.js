

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

  alert('sdffsdfsd')