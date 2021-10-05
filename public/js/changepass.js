$('.btn-email').click(function() {
    $('.email-form').addClass('d-none')
    $('.password-form').removeClass('d-none')
})

$('.btn-reset').click(function() {
    $('.email-form').removeClass('d-none')
    $('.password-form').addClass('d-none')
})

$('.password').on('input', function(){
    alert("Berhasil")
})

$('.confirm').on('input', function(){
    alert("Berhasil")
})


// Function untuk ShowHide Password
function password_show_hide() {
    var x = document.querySelector(".password");
    var show_eye = document.getElementById("show_eye_password");
    var hide_eye = document.getElementById("hide_eye_password");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
      x.type = "text";
      show_eye.style.display = "none";
      hide_eye.style.display = "block";
    } else {
      x.type = "password";
      show_eye.style.display = "block";
      hide_eye.style.display = "none";
    }
}

// Function untuk ShowHide Confirm Password
function confirm_show_hide() {
    var x = $(".confirm");
    var show_eye = $("#show_eye");
    var hide_eye = $("#hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
      x.type = "text";
      show_eye.style.display = "none";
      hide_eye.style.display = "block";
    } else {
      x.type = "password";
      show_eye.style.display = "block";
      hide_eye.style.display = "none";
    }
}

// Function untuk menghitung panjang password
// function validationLength(_name) {
//     var length = $(`.${_name}`)
//     if (length < 8){
//         // $(`.${_name}HelpBlock`).removeClass('d-none')
//         console.log(`.${_name}HelpBlock`)
//     } else {
//         // $(`.${_name}HelpBlock`).addClass('d-none')
//         console.log(`.${_name}HelpBlock`)
//     }
// }