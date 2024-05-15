<?php session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: form_login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
?>
<!doctype html>
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
    <?php
    $idmenu = $_GET["idmenu"];
    include "koneksi.php";

    $sql = "SELECT * FROM menu WHERE idmenu = '$idmenu'";
    $hasil = mysqli_query($kon, $sql);

    if (!$hasil) {
        die("Gagal query....");
    }

    $data = mysqli_fetch_array($hasil);
    $nama_menu = $data["nama_menu"];
    $harga = $data["harga"];
    $status = $data["status"];
    $foto = $data["foto_menu"];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-black">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="admin.php">Aplikasi Kasir</a>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll mx-3" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="menu_tampil.php">Daftar Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page"
                            href="menu_tersedia.php">MenuTersedia</a>
                    </li>
                </ul>
                <button type="button" class="btn btn-light">
                    <a href="logout.php" class="text-black text-decoration-none">Log Out</a>
                </button>
            </div>
        </div>
    </nav>
    <section>
        <div class="container mt-5">
            <h2 class="mb-4">EDIT MENU</h2>
            <form action="menu_simpan.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <input type="hidden" name="idmenu" value="<?php echo $idmenu; ?>">
                    <label for="nama_menu" class="col-sm-2 col-form-label">Nama Menu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_menu" name="nama_menu"
                            value="<?php echo $nama_menu; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga" class="col-sm-2 col-form-label">Harga Menu</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $harga; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="status" name="status" value=" <?php echo $status; ?>" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="foto_menu" class="col-sm-2 col-form-label">Gambar [max=5MB]</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="foto_menu" name="foto_menu">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="foto_menu" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input type="hidden" class="form-control" id="foto_lama" name="foto_lama"
                            value="<?php echo $foto; ?>">
                        <img src="<?php echo "thumb/thumb_" . $foto; ?>" width="100px">
                    </div>
                </div>
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> ' . $_SESSION['error_message'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    unset($_SESSION['error_message']);
                }
                ?>
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary" name="proses">Simpan</button>
                        <button type="reset" class="btn btn-secondary" name="reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>