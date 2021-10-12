<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- CSS Independent -->
    <link rel="stylesheet" href="../../public/css/main.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js" integrity="sha512-QMUqEPmhXq1f3DnAVdXvu40C8nbTgxvBGvNruP6RFacy3zWKbNTmx7rdQVVM2gkd2auCWhlPYtcW2tHwzso4SA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Hello, world!</title>
</head>
<body>
<?php
    if (isset($_GET['success'])){
        echo '<script>showPopUp()</script>';
    }
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-6"></div> <!-- Col-8 -->
        <div class="col-lg-4 col-md-6 col-xs-12 p-5 registrasi-side"> <!-- Start Registration Side -->
            <div class="registrasi-side-header mb-2">
                <p class="h2 text-center mb-3">Create an account</p>
                <p class="font-italic text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
            </div>

            <div class="registrasi-side-form">
                <form method="post" action="../../controller/registrationProcess.php">
                    <div class="form-group">
                        <label for="username">Name</label>
                        <input type="text" name="name" class="form-control" id="username">
                    </div>
                    <div class="form-group email-form">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" oninput="validate()" placeholder="example : ex@gmail.com">
<!--                        <small id="emailHelpBlock" class="form-text text-danger">-->
<!--                            Your email is not valid-->
<!--                        </small>-->
                    </div>

                    <div class="form-group">
                        <label for="phone">No. Hp</label>
                        <input id="phone" name="phoneNum" type="tel" class="form-control" placeholder="example : 081234567890">
                    </div>

                    <div class="form-group">
                        <label for="inlineFormInputGroup">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control password" aria-describedby="passwordHelpBlock">
                            <div class="input-group-append">
                                    <span class="input-group-text" onclick="password_show_hide()">
                                        <i class="fa fa-eye-slash" id="show_eye_password"></i>
                                        <i class="fa fa-eye d-none" id="hide_eye_password"></i>
                                      </span>
                            </div>
                        </div>
                        <small id="passwordHelpBlock" class="form-text">
                            Your password must be more than 8 characters!
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="inlineFormInputGroup">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="repeatPassword" class="form-control confirm" aria-describedby="confirmHelpBlock">
                            <div class="input-group-append">
                                    <span class="input-group-text" onclick="confirm_show_hide()">
                                        <i class="fa fa-eye-slash" id="show_eye"></i>
                                        <i class="fa fa-eye d-none" id="hide_eye"></i>
                                      </span>
                            </div>
                        </div>
                        <small id="confirmHelpBlock" class="form-text">
                            Make sure to match your password
                        </small>
<!--                            if (isset($_GET['pnm'])){-->
<!--                                echo '<small id="passwordHelpBlock" class="form-text text-danger">-->
<!--                                        Make sure to match your password!-->
<!--                                    </small>';-->
<!--                            }-->
                    </div>

                    <button class="btn btn-lg btn-submit w-100 mt-2">Registrasi</button>
                </form>

            </div>

            <div class="registrasi-side-bottom position-absolute mt-5">
                <p class="text-center">Already have an account? <a href="">Sign-In</a></p>
            </div>
        </div> <!-- End Registration Side -->

    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script src="https://use.fontawesome.com/7a7a4d3981.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../../public/js/registrasi.js"></script>
</body>
</html>