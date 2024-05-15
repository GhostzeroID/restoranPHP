<?php
session_start();

$nama = $_POST["pengguna"];
$email = $_POST["email"];
$password = md5($_POST["password"]);

include "koneksi.php";

if (empty($nama) || empty($email) || empty($password)) {
    $_SESSION['error_message'] = 'Semua kolom harus diisi';
    header("Location: form_register.php");
    exit();
}

$cekEmail = mysqli_query($kon, "SELECT * FROM pengguna WHERE email='$email'");
if (mysqli_num_rows($cekEmail) > 0) {
    $_SESSION['error_message'] = 'Email sudah digunakan. Silakan gunakan email lain.';
    header("Location: form_register.php");
    exit();
}
$cekPassword = mysqli_query($kon, "SELECT * FROM pengguna WHERE password='$password'");
if (mysqli_num_rows($cekPassword) > 0) {
    $_SESSION['error_message'] = 'Password sudah digunakan. Silakan gunakan password lain.';
    header("Location: form_register.php");
    exit();
}
$sql = "INSERT INTO pengguna (nama, email, password) VALUES ('$nama','$email','$password')";
$hasil = mysqli_query($kon, $sql);

if ($hasil) {
    header("Location: form_login.php");
    exit();
} else {
    $_SESSION['error_message'] = 'Terjadi kesalahan saat menambahkan pengguna!';
    header("Location: form_register.php");
    exit();
}
?>