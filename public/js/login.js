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
