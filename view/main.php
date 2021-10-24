<?php
    session_start();
    $cred = base64_decode($_SESSION['cred']);

//    if (time()-$_SESSION['accessTime'] > 60){
//        session_unset();
//        session_destroy();
//        header('Location: registration/registration.php');
//
//        $_SESSION['accessTime'] = time();
//    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- CSS Independent -->
    <link rel="stylesheet" href="../public/css/main.css">


    <title>Hello, world!</title>
  </head>
  <body>

    <div class="container-fluid border banner d-flex align-items-center">
        <div class="container text-center container-banner-text">
            <p class="h1">Workshop Belajar Batik</p>
            <p class="h3">Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
        </div>
    </div>
    
    <div class="container container-nav">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link text-white mr-4" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white mr-4" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white mr-4" href="#">Webinars</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white mr-4" href="#">Workshops</a>
                </li>
              </ul>
              <div class="my-2 my-lg-0">
                X
              </div>
            </div>
        </nav>
    </div>
    <div class="container container-event mt-5 mb-5">
      <div class="header-event mb-5">
        <p class="h1 text-center">Event</p>
      </div>
      <div class="owl-carousel owl-theme">
        <div class="item item1 rounded d-flex align-items-end">
          <div class="container deskripsi p-2">
            <p class="h3 nama-event text-center">Event 1</p>
            <p class="tanggal text-center">17, 24,31 July, 7 Agustus 2021</p>
            <div class="mt-3 text-center more d-none">
              <a href="details.php" class="btn btn-more w-75">Click More</a>
            </div>
          </div>
        </div>
        <div class="item item2 rounded d-flex align-items-end">
          <div class="container deskripsi p-2">
            <p class="h3 nama-event text-center">Event 1</p>
            <p class="tanggal text-center">17, 24,31 July, 7 Agustus 2021</p>
            <div class="mt-3 text-center more d-none">
              <button class="btn btn-more w-75">Click More</button>
            </div>
          </div>
        </div>
        <div class="item item3 rounded d-flex align-items-end">
          <div class="container deskripsi p-2">
            <p class="h3 nama-event text-center">Event 1</p>
            <p class="tanggal text-center">17, 24,31 July, 7 Agustus 2021</p>
            <div class="mt-3 text-center more d-none">
              <button class="btn btn-more w-75">Click More</button>
            </div>
          </div>
        </div>
        
    </div>
    </div>
    



        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://use.fontawesome.com/7a7a4d3981.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../public/js/main.js"></script>

    <script>
      
    </script>
  </body>
</html>