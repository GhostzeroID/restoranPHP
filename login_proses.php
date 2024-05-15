<?php
session_start();
$nama = $_POST["pengguna"];
$password = md5($_POST["password"]);

$dataValid = "YA";

if (strlen(trim($nama)) == 0) {
    $_SESSION['error_message'] = 'Terjadi Kesalahan ! Username Harus di isi.';
    header("Location: form_login.php");
    $dataValid = "TIDAK";
}
if (strlen(trim($password)) == 0) {
    $_SESSION['error_message'] = 'Terjadi Kesalahan ! Password Harus di isi.';
    header("Location: form_login.php");
    $dataValid = "TIDAK";
}
if ($dataValid == "TIDAK") {
    $_SESSION['error_message'] = 'Terjadi Kesalahan ! Username atau Password Harus di isi.';
    header("Location: form_login.php");
    exit();
}

include "koneksi.php";
$sql = "SELECT * FROM pengguna WHERE nama='$nama' AND password='$password' LIMIT 1";
$hasil = mysqli_query($kon, $sql) or die("Gagal koneksi");
$jumlah = mysqli_num_rows($hasil);

if ($jumlah > 0) {
    $row = mysqli_fetch_assoc($hasil);
    $id = session_id($row["iduser"]);
    $_SESSION["user_id"] = $row["iduser"];
    if ($nama == "admin" && $password == md5("admin123")) {
        $id =session_id($jumlah['iduser']);
        header("Location: admin.php");
        exit();
    } else {
        $id = session_id($jumlah['iduser']);
        header("Location: plgn_index.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Terjadi kesalahan! User atau Password salah.';
    header("Location: form_login.php");
    exit();
}
?>