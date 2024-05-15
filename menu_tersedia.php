<?php
$menu_pilih = 0;
if (isset($_SESSION["keranjang"])) {
    $menu_pilih = $_SESSION["keranjang"];
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
                echo "<button class='btn btn-danger'><a href='" . $_SERVER['PHP_SELF'] . "?idmenu=" . $row["idmenu"] . "' class='text-white text-decoration-none'>Pesan</a></button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>

        </tbody>
    </table>
</div>