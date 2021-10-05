import intlTelInput from 'intl-tel-input';

const input = document.querySelector("#phone");
intlTelInput(input, {
    // any initialisation options go here
});

function password_show_hide() {
  var x = document.querySelector(".password");
  var show_eye = document.getElementById("show_eye");
  var hide_eye = document.getElementById("hide_eye");
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