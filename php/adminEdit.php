<?php
    require_once('connection.php');

    if (!isset($_SESSION['edit'])) {
        header("Location: admin.php");
    }

    $barangNow = $listBarang[$_SESSION['edit']];

    $id = $barangNow['id_kategori'];
    $namaKategori = $conn -> query("SELECT * FROM kategori WHERE id_kategori = $id") -> fetch_assoc();
    $namaKategori = $namaKategori['nama_kategori'];

    if (isset($_REQUEST['cancel'])) {
        unset($_SESSION['edit']);
        header("Location: admin.php");
    }

    if (isset($_REQUEST['save'])) {
        $desc = $_REQUEST['descBarang'];
        $harga = $_REQUEST['hargaBarang'];
        $stok = $_REQUEST['stokBarang'];
        $foto = $_FILES['fotoBarang'];

        if ($harga < 0) {
            echo "<script>alert('Harga tidak boleh < 0')</script>";
        } else if ($stok < 0) {
            echo "<script>alert('Stok tidak boleh < 0')</script>";
        } else {
            if ($foto['error'] == 0) {
                //ADA FOTO
                $id = $barangNow['id_barang'];
                $lokasi = "../barang/";
                $namafoto = $id;
                $temp = $foto['tmp_name'];
                $lokasi .= $namafoto;
                move_uploaded_file($temp, $lokasi);

                //UPDATE DATABASE
                $sql = "UPDATE `barang` SET `desc_barang`='$desc',`harga_barang`='$harga',`stok_barang`='$stok',`foto_barang`='$lokasi' WHERE `id_barang` = '$id'";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute();
            } else {
                //TIDAK ADA FOTO
                //UPDATE DATABASE
                $sql = "UPDATE `barang` SET `desc_barang`='$desc',`harga_barang`='$harga',`stok_barang`='$stok' WHERE `id_barang` = '$id'";
                $stmt = $conn -> prepare($sql);
                $stmt -> execute();
            }

            header("Location: adminEdit.php");
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
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <button name="cancel">Cancel Edit</button>

        <h1>EDIT BARANG</h1>
        <table>
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
                    <textarea name="descBarang" cols="100" rows="10" style="resize: none;"><?=$barangNow['desc_barang']?></textarea>
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
                    <img src="<?=$barangNow['foto_barang']?>" style="width: 150px; height: 150px;">
                    <br>
                    <input type="file" name="fotoBarang">
                </td>
            </tr>
        </table>

        <button name="save">Save Edit</button>
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