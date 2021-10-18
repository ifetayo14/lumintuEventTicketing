let check = [false, false, false]

function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validate() {
  const result = $("#emailHelpBlock");
  const email = $("#email").val();

  if (validateEmail(email)) {
      result.text("Your email is valid")
      check[0] = true
      checkStatus()
  } else {
      result.text("Your email is not valid")
      check[0] = false
      checkStatus()
  }
  return false;
}


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
    check[1] = true
    checkStatus()
    return true
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
    check[2] = true
    checkStatus()
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

function checkStatus(){
  if(check.indexOf(false) == -1){
    $('.btn-registrasi').prop('disabled', false)
  } else {
    $('.btn-registrasi').prop('disabled', true)
  }
  
}