<?php session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: form_login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
?>
<?php
if (isset($_POST["idmenu"])) {
    $idmenu = $_POST["idmenu"];
    $foto_lama = $_POST["foto_lama"];
    $simpan = "EDIT";
} else {
    $simpan = "BARU";
}
if (isset($_POST["nama_menu"]) && isset($_POST["harga"]) && isset($_POST["status"])) {
    $nama_menu = htmlspecialchars($_POST["nama_menu"]);
    $harga = htmlspecialchars($_POST["harga"]);
    $status = htmlspecialchars($_POST["status"]);

    $foto = $_FILES["foto_menu"]["name"];
    $tmpName = $_FILES["foto_menu"]["tmp_name"];
    $size = $_FILES["foto_menu"]["size"];
    $type = $_FILES["foto_menu"]["type"];

    $maxSize = 50000000;
    $typeYgBoleh = array("image/jpeg", "image/png", "image/pjpeg");

    $dirFoto = "pict";
    if (!is_dir($dirFoto))
        mkdir($dirFoto);
    $fileTujuanFoto = $dirFoto . "/" . $foto;

    $dirThumb = "thumb";
    if (!is_dir($dirThumb))
        mkdir($dirThumb);
    $fileTujuanThumb = $dirThumb . "/thumb_" . $foto;

    $dataValid = "YA";
    if ($size > 0) {
        if ($size > $maxSize) {
            $_SESSION['error_message'] = 'File Gambar terlalu besar!.';
            header("Location: menu_isi.php");
            $dataValid = "TIDAK";
        }
        if (!in_array($type, $typeYgBoleh)) {
            $_SESSION['error_message'] = 'Type file tidak di kenal!.';
            header("Location: menu_isi.php");
            $dataValid = "TIDAK";
        }
    }
    if (strlen(trim($nama_menu)) == 0) {
        $_SESSION['error_message'] = 'Nama menu harus di isi!.';
        header("Location: menu_isi.php");
        $dataValid = "TIDAK";
    }
    if (strlen(trim($harga)) == 0) {
        $_SESSION['error_message'] = 'Harga menu harus di isi!.';
        header("Location: menu_isi.php");
        $dataValid = "TIDAK";
    }
    if (strlen(trim($status)) == 0) {
        $_SESSION['error_message'] = 'Status menu harus di isi!.';
        header("Location: menu_isi.php");
        $dataValid = "TIDAK";
    }
    if ($dataValid == "TIDAK") {
        $_SESSION['error_message'] = 'Terjadi kesalahan Silahkan isi ulang form!';
        header("Location: menu_isi.php");
        exit();
    }

    include "koneksi.php";
    if ($simpan == "EDIT") {
        if ($size == 0) {
            $foto = $foto_lama;
        }
        $sql = "UPDATE menu SET 
        nama_menu = '$nama_menu',
        harga = '$harga',
        status = '$status', 
        foto_menu = '$foto'
        WHERE idmenu = $idmenu";
    } else {
        $cekDuplikat = "SELECT COUNT(*) AS jumlah FROM menu WHERE nama_menu = '$nama_menu'";
        $hasilCek = mysqli_query($kon, $cekDuplikat);

        if (!$hasilCek) {
            $_SESSION['error_message'] = 'Gagal cek duplikat!.';
            header("Location: menu_isi.php");
        }

        $dataCek = mysqli_fetch_assoc($hasilCek);
        $jumlahDuplikat = $dataCek['jumlah'];

        if ($jumlahDuplikat > 0) {
            $_SESSION['error_message'] = 'Nama menu sudah ada, silahkan masukkan nama menu yang lain!';
            header("Location: menu_isi.php");
            exit();
        }
        $sql = "INSERT INTO menu (nama_menu,harga,status,foto_menu) VALUES ('$nama_menu','$harga','$status','$foto')";
    }

    $hasil = mysqli_query($kon, $sql);

    if (!$hasil) {
        $_SESSION['error_message'] = 'Gagal menyimpan menu, silahkan ulangi!';
        header("Location: menu_isi.php");
        exit();
    } else {
        header("Location: menu_tampil.php");
    }

    if ($size > 0) {
        if (!move_uploaded_file($tmpName, $fileTujuanFoto)) {
            $_SESSION['error_message'] = 'Gagal upload gambar!';
            header("Location: menu_isi.php");
            exit();
        } else {
            buat_thumbnail($fileTujuanFoto, $fileTujuanThumb);
        }
    }
    header("Location: menu_tampil.php");
} else {
    $_SESSION['error_message'] = 'Data tidak lengkap!';
    header("Location: menu_isi.php");
    exit();
}
function buat_thumbnail($file_src, $file_dst)
{
    list($w_src, $h_src, $type) = getimagesize($file_src);
    switch ($type) {
        case "1":
            $img_src = imagecreatefromgif($file_src);
            break;
        case "2":
            $img_src = imagecreatefromjpeg($file_src);
            break;
        case "3":
            $img_src = imagecreatefrompng($file_src);
            break;
    }
    $thumb = 100;
    if ($w_src > $h_src) {
        $w_dst = $thumb;
        $h_dst = round($thumb / $w_src * $h_src);
    } else {
        $w_dst = round($thumb / $h_src * $w_src);
        $h_dst = $thumb;
    }
    $img_dst = imagecreatetruecolor($w_dst, $h_dst);
    imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
    imagejpeg($img_dst, $file_dst);
    imagedestroy($img_src);
    imagedestroy($img_dst);
}
?>