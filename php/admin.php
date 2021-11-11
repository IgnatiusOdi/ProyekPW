<?php
    require_once('connection.php');

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    $countBarang = count($listBarang);
    $nextId = $countBarang + 1;

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        header("Location: login.php");
    }

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

    foreach ($listBarang as $key => $value) {
        if (isset($_REQUEST[$value['id_barang']])) {
            $_SESSION['edit'] = $key;
            header("Location: adminEdit.php?id_barang=".$value['id_barang']);
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
    <script src="../js/jquery.min.js"></script>
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
        <br>

        <h2>TABEL BARANG</h2>
        <input type="text" name="search" id="search" autocomplete="off" placeholder="Search" autofocus>
        <span>Jumlah Barang: <?=$nextId - 1?></span>
        <?php
            if ($listBarang != null) {
        ?>
            <div id="container">
                <table border=1>
                    <tr>
                        <th>NO.</th>
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
                                <td style="text-align: center;"><button name="<?=$value['id_barang']?>">Edit</button></td>
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
<script>
    function onlyNumberKey(key) {
        var ascii = (key.which) ? key.which : key.keyCode
        if (ascii > 31 && (ascii < 48 || ascii > 57))
            return false;
        return true;
    }
</script>
</html>