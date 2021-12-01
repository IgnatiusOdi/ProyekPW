<?php
    require_once('connection.php');

    $barangNow = $listBarang[$_REQUEST['id_barang'] - 1];

    $id = $barangNow['id_kategori'];
    $namaKategori = $conn -> query("SELECT * FROM kategori WHERE id_kategori = $id") -> fetch_assoc();
    $namaKategori = $namaKategori['nama_kategori'];

    if (isset($_REQUEST['save'])) {
        $desc = $_REQUEST['descBarang'];
        $harga = $_REQUEST['hargaBarang'];
        $stok = $_REQUEST['stokBarang'];
        $foto = $_REQUEST['fotoBarang'];

        if ($harga < 0) {
            echo "<script>alert('Harga tidak boleh < 0')</script>";
        } else if ($stok < 0) {
            echo "<script>alert('Stok tidak boleh < 0')</script>";
        } else {
            $sql = "UPDATE `barang` SET `desc_barang`=?,`harga_barang`=?,`stok_barang`=?,`foto_barang`=? WHERE `id_barang` = '$id'";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("siis", $desc, $harga, $stok, $foto);
            $stmt -> execute();
            header("Refresh: 0");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .content{
            padding: 1% 1%;
        }
    </style>
</head>
<body>
    <form action="" method="post" class="content">
        <a href="admin.php"><button type="button" name="back" class="btn btn-dark">Back</button></a>

        <h1>Edit Item</h1>
        <table class="table">
            <tr>
                <td>ID</td>
                <td>:</td>
                <td><?=$barangNow['id_barang']?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?=$barangNow['nama_barang']?></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td>
                    <textarea name="descBarang" cols="150" rows="5" style="resize: none;"><?=$barangNow['desc_barang']?></textarea>
                </td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>:</td>
                <td>
                    Rp. <input type="text" name="hargaBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" value="<?=$barangNow['harga_barang']?>" style="text-align: right; width: 100px;"> ,-
                </td>
            </tr>
            <tr>
                <td>Stok</td>
                <td>:</td>
                <td>
                    <input type="text" name="stokBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" value="<?=$barangNow['stok_barang']?>" style="text-align: right; width: 100px;">
                </td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>:</td>
                <td><?=$namaKategori?></td>
            </tr>
            <tr>
                <td>Foto Barang</td>
                <td>:</td>
                <td>
                    <input type="text" name="fotoBarang" style="width: 1000px;" value="<?=$barangNow['foto_barang']?>"><br>
                    <img src="<?=$barangNow['foto_barang']?>" style="width: 150px; height: 150px;">
                </td>
            </tr>
        </table>

        <button name="save" class="btn btn-success">Save Edit</button>
    </form>
</body>
<script>
    function onlyNumberKey(key) {
        var ascii = (key.which) ? key.which : key.keyCode
        if (ascii > 31 && (ascii < 48 || ascii > 57))
            return false;
        return true;
    }
</script>
</html>