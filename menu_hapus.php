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
</head>

<body>
    <section>
        <?php
        $idmenu = $_GET["idmenu"];
        include "koneksi.php";
        $sql = "SELECT * FROM menu WHERE idmenu = '$idmenu'";
        $hasil = mysqli_query($kon, $sql);
        if (!$hasil)
            die("Gagal query....");

        $data = mysqli_fetch_array($hasil);
        $nama = $data["nama_menu"];
        $harga = $data["harga"];
        $status = $data["status"];
        $foto = $data["foto_menu"];
        ?>

        <div class="container mt-5">
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-header">
                    <h5 class="card-title">Konfirmasi Hapus Menu</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Nama Barang:
                        <?php echo $nama; ?><br>
                        Harga Barang:
                        Rp <?php echo number_format($harga,0,',','.'); ?><br>
                        Stok:
                        <?php echo $status; ?><br>
                        Foto: <img src='thumb/thumb_<?php echo $foto; ?>' width='100px' /><br>
                    </p>
                    <p class="card-text">APAKAH DATA INI AKAN DIHAPUS?</p>
                    <a href='menu_hapus.php?idmenu=<?php echo $idmenu; ?>&hapus=1' class="btn btn-danger">YA</a>
                    <a href='menu_tampil.php' class="btn btn-secondary">TIDAK</a>
                </div>
            </div>
        </div>
        <?php
        if (isset($_GET['hapus'])) {
            $sql = "DELETE FROM menu WHERE idmenu = '$idmenu'";
            $hasil = mysqli_query($kon, $sql);
            if (!$hasil) {
                echo "Gagal Hapus Menu: $nama ..< br/> ";
                echo "<a href='menu_tampil.php'>Kembali ke Daftar Barang</a>";
            } else {
                $gbr = "pict/$foto";
                if (file_exists($gbr))
                    unlink($gbr);
                $gbr = "thumb/thumb_" . $foto;
                if (file_exists($gbr))
                    unlink($gbr);
                header('location:menu_tampil.php');
            }
        }
        ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>