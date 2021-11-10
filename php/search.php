<?php
    require_once('connection.php');

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $userNow = $listUser[$_SESSION['user']];

    if (isset($_REQUEST['logout'])) {
        unset($_SESSION['user']);
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <script src="../js/jquery.min.js"></script>
</head>
<body>
    <form action="" method="get">
        <button name="logout">Logout</button>
        <h1>Welcome, <?=$userNow['nama_user']?>!</h1>
        <h1>Search</h1>
        <input type="text" name="search" id="search" autocomplete="off" placeholder="Search" autofocus>
        <?php
            if ($listBarang != null) {
        ?>
            <div id="container">
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
                                <td>Rp. <?=number_format($value['harga_barang'],0,'','.')?>,-</td>
                                <td style="text-align: right;"><?=$value['stok_barang']?></td>
                                <?php
                                    $id = $value['id_barang'];
                                    $kategori = $conn -> query("SELECT * FROM kategori_barang WHERE id_barang = $id") -> fetch_assoc();

                                    $id = $kategori['id_kategori'];
                                    $namaKategori = $conn -> query("SELECT * FROM kategori WHERE id_kategori = $id") -> fetch_assoc();
                                    $namaKategori = $namaKategori['nama_kategori'];
                                ?>
                                <td><?=$namaKategori?></td>
                                <td><img src="<?=$value['foto_barang']?>" style="width: 50px; height: 50px;"></td>
                                <td><button name="<?=$value['id_barang']?>">Add to Cart</button></td>
                            </tr>
                    <?php
                        endforeach;
                    ?>
                </table>
            </div>
        <?php
            }
        ?>
    </form>
</body>
<script src="../js/script.js"></script>
</html>