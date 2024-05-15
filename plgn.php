<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;900&family=Red+Hat+Display:wght@500&family=Rubik:ital,wght@0,400;1,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style_admin.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-black">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Kopi Kipo</a>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll mx-3" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#product">Product</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-light">
                    <a href="form_login.php" class="text-black text-decoration-none">Log In</a>
                </button>
            </div>
        </div>
    </nav>

    <section id="home">
        <h1>Selamat Datang di Kopi Kipo!</h1>
        <p>Nikmati Suasana Ngopi Yang Santai, Akses Cepat Dan Mudah.</p>
        <img src="img/home.jpg" alt="Ilustrasi" class="illustration" style="width: 400px;">
    </section>

    <section id="about">
        <div class="container">
            <h1>About Us</h1>
            <p>
                Kopi Kipo adalah destinasi kopi yang menghadirkan pengalaman unik dalam menikmati secangkir kopi
                dengan suasana yang nyaman dan penuh kepuasan. Sebagai sebuah tempat bersantai, Kopi Kipo tidak hanya
                menawarkan kopi berkualitas tinggi tetapi juga menjadi tempat yang menyediakan kenikmatan dan layanan
                terbaik bagi para pengunjungnya.
            </p>
        </div>
    </section>
    <div class="container">
        <h1>Our Menu</h1>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="img/kopi2.jpg" class="card-img-top" alt="Menu 1">
                    <div class="card-body">
                        <h5 class="card-title">Special Coffee</h5>
                        <p class="card-text">Delicious coffee to kickstart your day.</p>
                        <a href="form_login.php" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="img/nasi.jpg" class="card-img-top" alt="Menu 2">
                    <div class="card-body">
                        <h5 class="card-title">Special Rice</h5>
                        <p class="card-text">Spicy rice pete to make happy your day.</p>
                        <a href="form_login.php" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="img/icecream.jpg" class="card-img-top" alt="Menu 3">
                    <div class="card-body">
                        <h5 class="card-title">Special Ice cream</h5>
                        <p class="card-text">Special for you the best of ice cream.</p>
                        <a href="form_login.php" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="product">

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>