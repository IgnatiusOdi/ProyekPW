<?php
    require_once('connection.php');

    $idTrans = $_REQUEST['id'];
    $q = $conn -> query("SELECT tanggal_transaksi as tanggal FROM htrans WHERE id_htrans='$idTrans'") -> fetch_assoc();
    $tanggalTransaksi = $q['tanggal'];
    $listHistory = $conn -> query("SELECT * FROM dtrans WHERE id_htrans='$idTrans'") -> fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
</head>
<body>
    <form action="" method="post">
        <a href="adminTransaction.php">Back</a>
        <h1><u>Transaction</u></h1>
        <h2>ID : <?=$idTrans?></h2>
        <h2>Date : <?=date('d F Y - H:i:s', strtotime($tanggalTransaksi))?></h2>
        <table class="table" border=1 style="font-size: 20px;">
                <tr>
                    <td>No.</td>
                    <td>Barang</td>
                    <td>Jumlah</td>
                    <td>Subtotal</td>
                </tr>
                <div class="cart">
                    <?php
                        $total = 0;
                        foreach ($listHistory as $key => $value) {
                            $barang = $listBarang[$value['id_barang'] - 1];
                            $foto = $barang['foto_barang'];
                            echo "<tr>";
                                echo "<td>".($key + 1).".</td>";
                                echo "<td><img src='".$foto."'><br>".$barang['nama_barang']."</td>";
                                echo "<td>".$value['jumlah']."</td>";
                                $harga = $barang['harga_barang'] * $value['jumlah'];
                                echo "<td>Rp. ".number_format($harga,0,'','.').",-</td>";
                            echo "</tr>";

                            $total += $harga;
                        }
                    ?>
                </div>
            </table>
            <h2>Total: Rp.<?=number_format($total,0,'','.')?>,-</h2>
    </form>
</body>
</html>