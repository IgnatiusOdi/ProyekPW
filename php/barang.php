<?php
    require_once('connection.php');
    $keyword = $_GET["keyword"];

    $query = "SELECT * FROM barang WHERE
                nama_barang LIKE '%$keyword%'";

    $listBarang = $conn -> query($query) -> fetch_all(MYSQLI_ASSOC);
?>
<table border=1>
    <tr>
        <th>ID</th>
        <th>NAMA</th>
        <th>HARGA</th>
        <th>STOK</th>
        <th>KATEGORI</th>
        <th>FOTO</th>
        <th>ACTION</th>
    </tr>
    <?php
        foreach ($listBarang as $key => $value) :
    ?>
            <tr>
                <td><?=$key + 1?>.</td>
                <td><?=$value['nama_barang']?></td>
                <td style="text-align: right;">Rp. <?=number_format($value['harga_barang'],0,'','.')?>,-</td>
                <td style="text-align: left;"><?=$value['stok_barang']?></td>
                <?php
                    $id = $value['id_barang'];
                    $kategori = $conn -> query("SELECT * FROM kategori_barang WHERE id_barang = $id") -> fetch_assoc();
                    
                    $id = $kategori['id_kategori'];
                    $namaKategori = $conn -> query("SELECT * FROM kategori WHERE id_kategori = $id") -> fetch_assoc();
                    $namaKategori = $namaKategori['nama_kategori'];
                ?>
                <td><?=$namaKategori?></td>
                <td><img src="<?=$value['foto_barang']?>" style="width: 100px; height: 100px;"></td>
                <td style="text-align: center;"><button name="<?=$value['id_barang']?>">
                    <?php
                        if (isset($_SESSION['admin'])) {
                            echo "Edit";
                        } else {
                            echo "Add to Cart";
                        }
                    ?>
                </button></td>
            </tr>
    <?php
        endforeach;
    ?>
</table>