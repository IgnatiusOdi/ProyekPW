<?php
    require_once('connection.php');
    $action = $_REQUEST['action'];
    
    if ($action == "deleteFromCart") {
        //DELETE DATA

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
    }
?>