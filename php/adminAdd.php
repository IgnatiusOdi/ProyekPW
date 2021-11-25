<?php
    require_once('connection.php');

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        header("Location: login.php");
    }

    $countBarang = count($listBarang);
    $nextId = $countBarang + 1;

    if (isset($_REQUEST['addBarang'])) {
        $nama = $_REQUEST['namaBarang'];
        $desc = $_REQUEST['descBarang'];
        $harga = $_REQUEST['hargaBarang'];
        $stok = $_REQUEST['stokBarang'];
        $kategori = $_REQUEST['kategoriBarang'];
        $foto = $_FILES['fotoBarang'];

        if ($nama == "") {
            echo "<script>alert('Nama masih kosong')</script>";
        } else if ($harga < 0) {
            echo "<script>alert('Harga tidak boleh < 0')</script>";
        } else if ($stok < 0) {
            echo "<script>alert('Stok tidak boleh < 0')</script>";
        } else if ($kategori == "") {
            echo "<script>alert('Kategori harus diisi')</script>";
        } else if ($foto['error'] == 4) {
            echo "<script>alert('Sertakan foto juga')</script>";
        } else if ($foto['size'] > 200000) {
            echo "<script>alert('Size File terlalu besar, MAKS. 200KB')</script>";
        }  else {
            // SAVE FOTO
            $lokasi = "../barang/";
            if (!file_exists($lokasi)) {
                @mkdir($lokasi);
            }
            $namafoto = $nextId;
            $temp = $foto['tmp_name'];
            $lokasi .= $namafoto;
            move_uploaded_file($temp, $lokasi);

            //ADD TO BARANG
            $sql = "INSERT INTO `barang`(`nama_barang`, `desc_barang`, `harga_barang`, `stok_barang`, `foto_barang`) VALUES (?,?,?,?,?)";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("ssiis", $nama, $desc, $harga, $stok, $lokasi);
            $stmt -> execute();

            //ADD TO KATEGORI_BARANG
            $sql = "INSERT INTO `kategori_barang` (`id_barang`, `id_kategori`) VALUES (?,?)";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("ii", $nextId, $kategori);
            $stmt -> execute();

            header("Location: admin.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Barang</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Admin Add Barang</h1>
        <a href="admin.php">Home</a>
        Add Barang
        <a href="adminTransaksi.php">Transaksi</a>
        <button name="logout">Logout</button><br>

        <h2>Item</h2>
            <table>
                <tr>
                    <td>Nama Barang</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="namaBarang" placeholder="Nama Barang" style="width: 500px;">
                    </td>
                </tr>
                <tr>
                    <td>Deskripsi Barang</td>
                    <td>:</td>
                    <td>
                        <textarea name="descBarang" cols="100" rows="10" placeholder="Deskripsi Barang" style="resize: none;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Harga Barang</td>
                    <td>:</td>
                    <td>
                        Rp. <input type="text" name="hargaBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" placeholder="999.999.999" style="text-align: right; width: 100px;"> ,-
                    </td>
                </tr>
                <tr>
                    <td>Stok Barang</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="stokBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" placeholder="123456789" style="text-align: right; width: 100px;">
                    </td>
                </tr>
                <tr>
                    <td>Kategori Barang</td>
                    <td>:</td>
                    <td>
                        <?php
                            foreach($listKategori as $key => $value) {
                        ?>
                            <input type="radio" name="kategoriBarang" value=<?=$value['id_kategori']?>><?=$value['nama_kategori']?>
                            <br>
                        <?php
                            }
                        ?>
                        
                    </td>
                </tr>
                <tr>
                    <td>Foto Barang</td>
                    <td>:</td>
                    <td><input type="file" name="fotoBarang"></td>
                </tr>
            </table>
            <button name="addBarang">Add Barang</button>

            <h2>Bulk Item</h2>
            <table>
                <tr>
                    <td>CSV Barang</td>
                    <td>:</td>
                    <td><input type="file" name="csv"></td>
                </tr>
            </table>
            <button name="addAll">Add All</button>
    </form>
</body>
</html>