<?php
    require_once('connection.php');
    $action = $_REQUEST['action'];

    if ($action == "search") {
        $category = $_REQUEST['category'];
        $itemname = $_REQUEST['itemname'];

        if (!empty($category)) {
            $listBarang = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%' AND id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%')") -> fetch_all(MYSQLI_ASSOC);
        } else {
            $listBarang = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%'") -> fetch_all(MYSQLI_ASSOC);
        }

        foreach ($listBarang as $key => $value) {
            echo "<div class='card col' onclick=detail(".$value['id_barang'].")>";
                echo "<img src=".$value['foto_barang'].">;";
                echo "<h3 style='text-align: center;'>".$value['nama_barang']."</h3>";
                echo "<div style='margin-bottom: 10px;'>Rp. ".number_format($value['harga_barang'], 0, '', '.').",-</div>";
                echo "<div style='margin-bottom: 10px;'>Stok : ".number_format($value['stok_barang'], 0, '', '.')."</div>";
                echo "<button style='margin-bottom: 10px;'>Add to Cart</button>";
            echo "</div>";
         }
    } else if ($action == "deleteFromCart") {
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