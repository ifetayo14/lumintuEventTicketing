function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validate() {
  const result = $("#emailHelpBlock");
  const email = $("#email").val();

  if (validateEmail(email)) {
      result.text("Your email is valid")
  } else {
      result.text("Your email is not valid")
  }
  return false;
}


$('.password').on('input', function(){
  if($('.password').val().length > 8) {
      $('#passwordHelpBlock').addClass('d-none')
  } else {
      $('#passwordHelpBlock').removeClass('d-none')
  }
})

$('.confirm').on('input', function(){
  if($('.confirm').val() === $('.password').val()) {
      $('#confirmHelpBlock').addClass('d-none')
  } else {
      $('#confirmHelpBlock').removeClass('d-none')
  }
})

function showPopUp(){
  Swal.fire({
    icon: 'success',
    title: 'Registration Success!',
    showConfirmButton: true,
    confirmButtonColor: '#3085d6',
    text: "Make sure to check your email to verify your account.",
  })
}

//  REGEX NUMBER

function allLetter(inputtxt){ 
  var letters = /^[a-zA-Z\s]*$/; 
  if(inputtxt.value.match(letters)){
    $('#nameHelpBlock').text = "Numbers Not Allowed"
    $('#nameHelpBlock').addClass('d-none')
  }
  else{
    let str = $('.name-input').val()
    $('#nameHelpBlock').text = "Numbers Not Allowed"
    $('#nameHelpBlock').removeClass('d-none')
    Swal.fire({
      icon: 'error',
      title: 'Numbers Not Allowed!',
      showConfirmButton: true,
      confirmButtonColor: '#3085d6',
      text: " Please Check Your Input!",
    })
    $('.name-input').val(str.substring(0, str.length - 1))
    return false;
  }
}

function allNumber(inputnbr){
  var numbers = /^[0-9]*$/;
  if(inputnbr.value.match(numbers)){
    $('#phoneHelpBlock').text = "Numbers Not Allowed"
    $('#phoneHelpBlock').addClass('d-none')
  }
  else{
    let str = $('.phone-input').val()
    $('#phoneHelpBlock').text = "Numbers Not Allowed"
    $('#phoneHelpBlock').removeClass('d-none')
    Swal.fire({
      icon: 'error',
      title: 'Letter Not Allowed!',
      showConfirmButton: true,
      confirmButtonColor: '#3085d6',
      text: " Please Check Your Input!",
    })
    $('.phone-input').val(str.substring(0, str.length - 1))
    return false;
  }
}