<?php
    require_once('connection.php');

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    $listBarang = $conn -> query("SELECT * FROM barang") -> fetch_all(MYSQLI_ASSOC);
    $listKategori = $conn -> query("SELECT * FROM kategori") -> fetch_all(MYSQLI_ASSOC);
    
    $countBarang = $conn -> query("SELECT COUNT(*) FROM barang") -> fetch_all(MYSQLI_ASSOC);
    $nextId = $countBarang[0];
    $nextId = (int)$nextId['COUNT(*)'] + 1;

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        header("Location: login.php");
    }

    if (isset($_REQUEST['addBarang'])) {
        $nama = $_REQUEST['namaBarang'];
        $desc = $_REQUEST['descBarang'];
        $harga = $_REQUEST['hargaBarang'];
        $stok = $_REQUEST['stokBarang'];
        if (isset($_REQUEST['kategoriBarang'])) {
            $kategori = $_REQUEST['kategoriBarang'];
        }
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
        } else {
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
            $sql = "INSERT INTO `barang`(`nama_barang`, `desc_barang`, `harga_barang`, `stok_barang`, `foto_barang`) VALUES ('$nama', '$desc', '$harga', '$stok', '$lokasi')";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();

            //ADD TO KATEGORI_BARANG
            $sql = "INSERT INTO `kategori_barang` (`id_barang`, `id_kategori`) VALUES ('$nextId', '$kategori')";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();

            header("Location: admin.php");
        }
    }

    foreach ($listBarang as $key => $value) {
        if (isset($_REQUEST[$value['id_barang']])) {
            $_SESSION['edit'] = $key;
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
    <title>Admin</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Admin Page</h1>
        <button name="logout">Logout</button>

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
                    Rp. <input type="text" name="hargaBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" placeholder="000.000.000" style="text-align: right; width: 100px;"> ,-
                </td>
            </tr>
            <tr>
                <td>Stok Barang</td>
                <td>:</td>
                <td>
                    <input type="text" name="stokBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" placeholder="987654321" style="text-align: right; width: 100px;">
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
        <br>

        <h2>TABEL BARANG</h2>
        <div>Jumlah Barang: <?=$nextId - 1?></div>
        <input type="text" name="search">
        <button name="search">Search</button>
        <?php
            if ($listBarang != null) {
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
                    foreach ($listBarang as $key => $value) {
                ?>
                        <tr>
                            <td><?=$value['id_barang']?>.</td>
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
                            <td><button name="<?=$value['id_barang']?>">Edit</button></td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        <?php
            }
        ?>
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