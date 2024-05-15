<?php session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: form_login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembelian</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        table {
            margin-top: 20px;
        }

        th,
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        include "koneksi.php";
        $idhjual = mysqli_real_escape_string($kon, $_GET["idhjual"]);
        $sqlhjual = "SELECT * FROM hjual WHERE idhjual = $idhjual ";

        $hasilhjual = mysqli_query($kon, $sqlhjual);
        $rowhjual = mysqli_fetch_assoc($hasilhjual);
        echo "<h2 class='text-center mt-4 mb-4'>BUKTI PEMBELIAN</h2>";

        $sqldjual = "SELECT menu.nama_menu, djual.harga, djual.qty,
            (djual.harga * djual.qty) AS jumlah
            FROM djual INNER JOIN menu
            ON djual.idmenu = menu.idmenu
            WHERE djual.idhjual = $idhjual ";
        $hasildjual = mysqli_query($kon, $sqldjual);

        echo "<table class='table table-bordered table-hover'>";
        echo "<thead class='thead-dark'>";
        echo "<tr>";
        echo "<th>Nota</th>";
        echo "<th>Nama</th>";
        echo "<th>Meja</th>";
        echo "<th>Tanggal</th>";
        echo "<th> Nama Menu </th>";
        echo "<th> Quantity </th>";
        echo "<th> Harga </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $totalharga = 0;
        $totalqty = 0;
        while ($rowdjual = mysqli_fetch_assoc($hasildjual)) {
            echo "<tr>";
            echo "<td>" . date("Ymd") . $rowhjual['idhjual'] . "</td>";
            echo "<td>" . $rowhjual['nama_pembeli'] . "</td>";
            echo "<td>" . $rowhjual['no_meja'] . "</td>";
            echo "<td>" . $rowhjual['tanggal'] . "</td>";
            echo " <td> " . $rowdjual['nama_menu'] . " </td>";
            echo " <td> " . $rowdjual['qty'] . " </td>";
            echo "<td>Rp " . number_format($rowdjual["harga"], 0, ',', '.') . "</td>";
            echo "</tr>";
            $totalharga = $totalharga + $rowdjual['jumlah'];
            $totalqty = $totalqty + $rowdjual['qty'];
        }
        echo "<td colspan='1'><strong>Jumlah</strong></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td> <strong>$totalqty</strong></td>";
        echo "<td><strong>Rp" . number_format($totalharga, 0, ',', '.') . "</strong></td>";
        echo "</tr>";
        echo "<tr>";
        echo "</tbody>";
        echo "</table>";

        // Tombol Kembali dan Print
        echo "<div class='text-center mt-4'>";
        echo "<a href='javascript:window.print()' class='btn btn-primary mr-2'>Print</a>";
        echo "<a href='javascript:history.back()' class='btn btn-secondary'>Kembali</a>";
        echo "</div>";
        ?>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>