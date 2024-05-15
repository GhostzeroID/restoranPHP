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

<table class="table">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah Pesan</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dirThumb = "thumb";
        if (!is_dir($dirThumb)) {
            mkdir($dirThumb);
        }
        $totalPesanan = 0;
        $no = 0;
        while ($row = mysqli_fetch_assoc($hasil)) {
            echo "<tr>";
            echo "<td><img src='{$dirThumb}/thumb_{$row["foto_menu"]}' width='50' height='50'></td>";
            echo "<td>" . $row["nama_menu"] . "</td>";
            echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
            echo "<td><input type='number' name='jumlah_pesan[{$row["idmenu"]}]' value='1' min='1'></td>";
            $totalHarga = $row["harga"] * 1;
            echo "<td>Rp " . number_format($totalHarga, 0, ',', '.') . "</td>";
            echo "</tr>";
            $totalPesanan += $totalHarga;
        }
        ?>
    </tbody>
</table>

<input type="submit" value="Pesan" class="btn btn-primary">
</form>