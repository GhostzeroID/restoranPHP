<?php
$nama_pembeli = $_POST["nama_pembeli"];
$no_meja = $_POST["no_meja"];
$tanggal = date("Y-m-d");
$menu_pilih = "";
$qty = $_POST['jumlah_pesan'];

$dataValid = "YA";
if (strlen(trim($nama_pembeli)) == 0) {
    $dataValid = "TIDAK";
}
if (strlen(trim($no_meja)) == 0) {
    $dataValid = "TIDAK";
}
if (isset($_COOKIE["keranjang"])) {
    $menu_pilih = $_COOKIE["keranjang"];
} else {
    $dataValid = "TIDAK";
}
if ($dataValid == "TIDAK") {
    $redirectPage = isset($_GET['admin']) && $_GET['admin'] == 'true' ? 'pesan_admin.php' : 'pesan_plgn.php';
    header("Location: $redirectPage");
    exit;
}
include "koneksi.php";

$simpan = true;
$transaksi = mysqli_begin_transaction($kon);
$sql = "INSERT INTO hjual (tanggal, nama_pembeli, no_meja) VALUES ('$tanggal','$nama_pembeli','$no_meja') ";

$hasil = mysqli_query($kon, $sql);
if (!$hasil) {
    echo "gagal simpan....<br>";
    $simpan = false;
}

$idhjual = mysqli_insert_id($kon);
if ($idhjual == 0) {
    echo "Data pembeli tidak ada<br>";
    $simpan = false;
}

$menu_array = explode(",", $menu_pilih);
$jumlah = count($menu_array);

if ($jumlah == 0) {
    echo "Tidak ada menu yang di pilih <br>";
    $simpan = false;
} else {
    foreach ($menu_array as $idmenu) {
        if ($idmenu == 0) {
            continue;
        }
        $sql = "SELECT * FROM menu WHERE idmenu = '$idmenu'";
        $hasil = mysqli_query($kon, $sql);
        if (!$hasil) {
            echo "Menu tidak ada <br>";
            $simpan = false;
            break;
        } else {
            $row = mysqli_fetch_assoc($hasil);
            $status = 'Tersedia';
            $harga = $row['harga'];
        }
        $qty_menu = $qty[$idmenu];
        $sql = "INSERT INTO djual (idhjual,idmenu,qty,harga) VALUES ('$idhjual','$idmenu','$qty_menu','$harga')";
        $hasil = mysqli_query($kon, $sql);
        if (!$hasil) {
            echo "detail jual gagal simpan <br>";
            $simpan = false;
            break;
        }
        $sql = "UPDATE menu SET status = '$status' WHERE idmenu = '$idmenu'";
        $hasil = mysqli_query($kon, $sql);
        if (!$hasil) {
            echo "Update Status Menu gagal <br>";
            $simpan = false;
            break;
        }
    }
}
if ($simpan) {
    $komit = mysqli_commit($kon);
} else {
    $rollback = mysqli_rollback($kon);
    echo "pembelian gagal<br>
    <input type='button' value='kembali' onClick='self.history.back()'>";
    exit;
}
header("Location: bukti_beli_plgn.php?idhjual=$idhjual");
echo "Data siap disimpan";
setcookie('keranjang', $menu_pilih, time() - 3600);
?>