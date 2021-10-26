<?php
    session_start();
    $_SESSION['cred'] = $_GET['m'];
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- CSS Independent -->
    <link rel="stylesheet" href="../public/css/main.css">

    <title>Status Pesanan</title>
</head>

<body>
<div class="container py-4">
    <form action="../controller/orderProcess.php" method="post">
        <div class="text-center title-page">
            <p class="h2">Status Pesanan</p>
        </div>
        <div class="banner-status align-middle rounded my-4 container-fluid text-white text-center">
            <div class="container w-50 rounded details-pageStatus p-5 h-100 align-middle">
                <p class="h1 nama-event">Dream World Wide in Jogja</p>
                <p class="h4 tanggal mb-4">By Lumintu Logic</p>
            </div>
        </div>


        <div class="container mb-3 d-none voucher text-right">
            <div class="d-flex justify-content-end">
                <input type="text" name="voucher" class="form-control kode-input w-25" placeholder="Voucher Code">
            </div>
        </div>

        <div class="container">
            <table class="table table-responsive-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Ticket</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total Invoice :</th>
                    <td>
                        <input type="text" class="input-status" id="total-harga" name="total-harga" value="0" readonly/>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center py-4">
            <button class="rounded py-2 px-5 btn-checkout" disabled>
                Checkout
            </button>
        </div>
    </form>
</div>

<div class="outer d-none" id="loader">
    <div class="middle">
        <div class="inner text-center">
            <blockquote class="blockquote text-center">
                <p class="mb-0">Sabar dan ikhlas bisa menjadikan kamu seorang yang mulia dan terhormat di dunia sekalipun kamu bukan apa-apa.</p>
                <footer class="blockquote-footer">Someone famous in <cite title="Source Title">PINTAR</cite></footer>
            </blockquote>
            <div class="spinner-border text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script src="https://use.fontawesome.com/7a7a4d3981.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../public/js/statuspesanan.js"></script>
</body>

</html>