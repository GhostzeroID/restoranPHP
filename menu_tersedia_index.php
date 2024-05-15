<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: form_login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
?>
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
    <link rel="stylesheet" href="css/menu_tampil.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-black">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="admin.php">Aplikasi Kasir</a>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll mx-3" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="menu_tampil.php">Daftar Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="menu_tersedia_index.php">Menu
                            Tersedia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page"
                            href="Keranjang_menu_index.php">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="pesan_admin.php">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="data_transaksi.php">Data
                            Orderan</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-light">
                    <a href="logout.php" class="text-black text-decoration-none">Log Out</a>
                </button>
            </div>
        </div>
    </nav>
    <section>
    <?php
        $menu_pilih = 0;
        if (isset($_COOKIE["keranjang"])) {
            $menu_pilih = $_COOKIE["keranjang"];
        }
        if (isset($_GET["idmenu"])) {
            $idmenu = $_GET["idmenu"];
            $menu_pilih = $menu_pilih . "," . $idmenu;
            setcookie('keranjang', $menu_pilih, time() + 3600);
        }

        include "koneksi.php";
        $sql = "SELECT * FROM menu WHERE idmenu NOT IN (" . $menu_pilih . ") AND status = 'Tersedia' ORDER BY idmenu DESC";
        $hasil = mysqli_query($kon, $sql);

        if (!$hasil) {
            die("gagal query......" . mysqli_error($kon));
        }
        ?>

        <div class="container">
            <div class="row">
                <?php
                $dirThumb = "thumb";
                if (!is_dir($dirThumb)) {
                    mkdir($dirThumb);
                }

                while ($row = mysqli_fetch_assoc($hasil)) {
                    ?>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img src="<?= "{$dirThumb}/thumb_{$row['foto_menu']}" ?>" class="card-img-top img-fluid"
                                alt="<?= $row['nama_menu'] ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $row["nama_menu"] ?>
                                </h5>
                                <p class="card-text">Rp
                                    <?= number_format($row["harga"], 0, ',', '.') ?>
                                </p>
                                <p class="card-text">
                                    <?= $row["status"] ?>
                                </p>
                                <a href="<?= $_SERVER['PHP_SELF'] ?>?idmenu=<?= $row["idmenu"] ?>"
                                    class="btn btn-danger text-white">Pesan</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>