const INPUT_PHONE = document.querySelector("#phone");
const RESULT = $("#emailHelpBlock");
const NAME_HELPBLOCK = $('#nameHelpBlock')
const PHONE_HELPBLOCK = $('#phoneHelpBlock')
const NAME_INPUT = $(".name-input")
const PHONE_INPUT = $(".phone-input")
const REGEX_LETTER = /^[a-zA-Z\s]*$/;
const REGEX_NUMBER = /^[0-9]*$/;
const REGEX_EMAIL = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

let check = [true, false, false, false]

// Function for Change Dial Code By Selection Flag
let getDialCode = () => {
    $("#phone").val(`${iti.getSelectedCountryData().dialCode}`);
}

// Function for Validate Email
let validate = () => {
    const EMAIL_VALUE = $("#email").val();
    if (validateEmail(EMAIL_VALUE)) {
        RESULT.text("Your email is valid")
        check[0] = true
        checkStatus()
    } else {
        RESULT.text("Your email is not valid")
        check[0] = false
        checkStatus()
    }
    return false;
}

// let showPopUp = () => {
//     Swal.fire({
//         icon: 'success',
//         title: 'Registration Success!',
//         showConfirmButton: true,
//         confirmButtonColor: '#3085d6',
//         text: "Make sure to check your email to verify your account.",
//     })
// }

// let showMailExist = () => {
//     Swal.fire({
//         icon: 'success',
//         title: 'Registration Failed!',
//         showConfirmButton: true,
//         confirmButtonColor: '#3085d6',
//         text: `Your Email "${EMAIL_VALUE}" already exists!"`,
//     })
// }

let allLetter = (inputtxt) => {
    if (inputtxt.value.match(REGEX_LETTER)) {
        NAME_HELPBLOCK.text = "Numbers Not Allowed"
        NAME_HELPBLOCK.addClass('d-none')
        check[1] = true
        checkStatus()
        return true
    }
    else {
        NAME_HELPBLOCK.text = "Numbers Not Allowed"
        NAME_HELPBLOCK.removeClass('d-none')
        Swal.fire({
            icon: 'error',
            title: 'Numbers Not Allowed!',
            showConfirmButton: true,
            confirmButtonColor: '#3085d6',
            text: " Please Check Your Input!",
        })
        NAME_INPUT.val("")
        check[1] = false
        checkStatus()
        return false;
    }
}

let allNumber = (inputNumber) => {
    let length = INPUT_PHONE.value.length
    if (inputNumber.value.match(REGEX_NUMBER)) {
      PHONE_HELPBLOCK.addClass("d-none");
      if (length < 9) {
        PHONE_HELPBLOCK.html("Minimum Phone Number Allowed 9 digit");
        PHONE_HELPBLOCK.removeClass("d-none");
        check[2] = false
      } else {
        PHONE_HELPBLOCK.addClass("d-none");
        check[2] = true;
      }
      checkStatus();
      return true
  
    } else {
      PHONE_HELPBLOCK.text = "Letter Not Allowed";
      PHONE_HELPBLOCK.removeClass("d-none");
      Swal.fire({
        icon: "error",
        title: "Letter Not Allowed!",
        showConfirmButton: true,
        confirmButtonColor: "#3085d6",
        text: " Please Check Your Input!",
      });
      getDialCode();
      check[2] = false;
      checkStatus();
      return false;
    }
    
  
};

let checkStatus = () => {
    if (check.indexOf(false) == -1) {
        $('.btn-accept').prop('disabled', false)
    } else {
        $('.btn-accept').prop('disabled', true)
    }

}

let iti = intlTelInput(INPUT_PHONE, {
    utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js",
});

$(document).ready(() => {
    iti.setCountry("id");
    getDialCode();
});

INPUT_PHONE.addEventListener("countrychange", function () {
    getDialCode();
});




$("#selectAgree").change(function () {
    if (this.checked) {
        check[3] = true;
    } else {
        check[3] = false;
    }
    checkStatus()
});

$( ".btn-accept" ).click(function() {
    Swal.fire({
        icon: 'success',
        title: 'Data saved successfully!',
        showConfirmButton: true,
        confirmButtonColor: '#3085d6',
        text: "Thank you for filling out this form",
    })
});
