<?php
$menu_pilih = 0;
if (isset($_COOKIE["keranjang"])) {
    $menu_pilih = $_COOKIE["keranjang"];
}
if (isset($_GET["idmenu"])) {
    $idmenu = $_GET["idmenu"];
    $menu_pilih = str_replace(("," . $idmenu), "", $menu_pilih);
    setcookie('keranjang', $menu_pilih, time() + 3600);
}

include "koneksi.php";
$sql = "SELECT * FROM menu WHERE idmenu IN (" . $menu_pilih . ") ORDER BY idmenu DESC";
$hasil = mysqli_query($kon, $sql);

if (!$hasil) {
    die("gagal query......" . mysqli_error($kon));
}
?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dirThumb = "thumb";
            if (!is_dir($dirThumb))
                mkdir($dirThumb);

            $no = 0;
            while ($row = mysqli_fetch_assoc($hasil)) {
                echo "<tr>";
                echo "<td><img src='{$dirThumb}/thumb_{$row["foto_menu"]}' width='50' height='50'></td>";
                echo "<td>" . $row["nama_menu"] . "</td>";
                echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>";
                echo "<button class='btn btn-danger'><a href='" . $_SERVER['PHP_SELF'] . "?idmenu=" . $row["idmenu"] . "' class='text-white text-decoration-none'>Batal</a></button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>