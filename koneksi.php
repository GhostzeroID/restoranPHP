<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$host = "localhost";
$user = "root";
$pass = "";
$db = "rumah_makan";

$kon = mysqli_connect($host, $user, $pass);
$hasil = mysqli_select_db($kon, $db);
if (!$hasil)
    if (!$kon)
        die("Gagal Koneksi.....");
if (!$hasil) {
    $hasil = mysqli_query($kon, "CREATE DATABASE IF NOT EXISTS $db");
    if (!$hasil)
        die("Gagal Buat Database....");
    else
        $hasil = mysqli_select_db($kon, $db);
    if (!$hasil)
        die("Gagal Konek Database");
}
$sqlTabelMenu = "CREATE TABLE IF NOT EXISTS menu (
    idmenu INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nama_menu VARCHAR(40) NOT NULL,
    harga INT NOT NULL DEFAULT 0,
    status VARCHAR(20) NOT NULL ,
    foto_menu VARCHAR(70) NOT NULL DEFAULT '',
    INDEX idx_nama_menu (nama_menu))";

mysqli_query($kon, $sqlTabelMenu) or die("Gagal Buat Tabel Menu ");
$sqlTabelHjual = "CREATE TABLE IF NOT EXISTS hjual (
    idhjual INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tanggal DATE NOT NULL,
    nama_pembeli VARCHAR(40) NOT NULL,
    no_meja VARCHAR(20) NOT NULL DEFAULT ''
    )";

mysqli_query($kon, $sqlTabelHjual) or die("Gagal Buat Tabel Header Jual ");
$sqlTabelDjual = "CREATE TABLE IF NOT EXISTS djual (
    iddjual INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idhjual INT NOT NULL,
    idmenu INT NOT NULL,
    qty INT NOT NULL,
    harga INT NOT NULL
)";
mysqli_query($kon, $sqlTabelDjual) or die("Gagal Buat Tabel Detail Jual ");

$sqlTabelUser = "CREATE TABLE IF NOT EXISTS pengguna (
    iduser INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(30) NOT NULL,
    password VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

mysqli_query($kon, $sqlTabelUser) or die("Gagal buat table user");


$sql = "SELECT * FROM pengguna";
$hasil = mysqli_query($kon, $sql);
$jumlah = mysqli_num_rows($hasil);

if ($jumlah == 0) {
    $sql = "INSERT INTO pengguna (nama, email, password) VALUES ('admin','admin@gmail.com',md5('admin123'))";
    mysqli_query($kon, $sql);
}

?>