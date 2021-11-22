<?php
    require_once('connection.php');

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $idUser = $_SESSION['user'] + 1;
    $listCart = $conn -> query("SELECT * FROM cart WHERE id_users='$idUser'") -> fetch_all(MYSQLI_ASSOC);
    $hargaTotal = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <div class="header">
        <a href="home.php">Home</a>
        <a href="search.php">Search</a>
        <a href="history.php">History</a>
    </div>
    <table border=1>
        <tr>
            <td>No.</td>
            <td>Nama Barang</td>
            <td>Jumlah</td>
            <td>Harga</td>
            <td>Action</td>
        </tr>
        <?php
            foreach ($listCart as $key => $value) {
                echo "<tr>";
                    echo "<td>".($key + 1).".</td>";
                    $barang = $listBarang[$value['id_barang'] - 1];
                    echo "<td><img src=".$barang['foto_barang']."><br>".$barang['nama_barang']."</td>";
                    echo "<td>".$value['jumlah']."</td>";
                    echo "<td>Rp. ".number_format($barang['harga_barang'],0,'','.').",-</td>";
                    echo "<td><button name='delete-".$value['id_cart']."'>Cancel</button></td>";
                echo "</tr>";
                $hargaTotal += $value['jumlah'] * $barang['harga_barang'];
            }
        ?>
    </table>
    <h3>Total: Rp. <?=number_format($hargaTotal,0,'','.')?>,-</h3>
    <button>Checkout</button>
</body>
</html>