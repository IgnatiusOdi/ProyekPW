<?php
    require_once("connection.php");

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    $listBarang = $conn -> query("SELECT * FROM barang") -> fetch_all(MYSQLI_ASSOC);

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        header("Location: login.php");
    }

    if (isset($_REQUEST['addBarang'])) {
        $nama = $_REQUEST['namaBarang'];
        $desc = $_REQUEST['descBarang'];
        $harga = $_REQUEST['hargaBarang'];

        if ($nama == "" || $harga <= 0) {
            echo "<script>alert('REQUIRED')</script>";
        } else {
            //ADD TO DATABASE
            

            //SAVE FOTO
            $lokasi = "../barang/";
            @mkdir($lokasi);

            $foto = $_FILES['fotoBarang']['name'];
            $temp = $_FILES['fotoBarang']['tmp_name'];

            move_uploaded_file($temp, $lokasi.$foto);
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
                <td><input type="text" name="namaBarang" style="width: 500px;"></td>
            </tr>
            <tr>
                <td>Deskripsi Barang</td>
                <td>:</td>
                <td><textarea name="descBarang" cols="100" rows="10" style="resize: none;"></textarea></td>
            </tr>
            <tr>
                <td>Harga Barang</td>
                <td>:</td>
                <td><input type="number" name="hargaBarang"></td>
            </tr>
            <tr>
                <td>Kategori Barang</td>
                <td>:</td>
                <td><input type="checkbox" name="hargaBarang"></td>
            </tr>
            <tr>
                <td>Foto Barang</td>
                <td>:</td>
                <td><input type="file" name="fotoBarang"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <button name="addBarang">Add Barang</button>
        <br>

        <input type="text" name="search">
        <button name="search">Search</button>
        <?php
            if ($listBarang != null) {
        ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>NAMA</th>
                    <th>HARGA</th>
                    <th>FOTO</th>
                    <th>ACTION</th>
                </tr>
                <?php
                    foreach ($listBarang as $key => $value) {
                ?>
                        <tr>
                            <td><?=$value['id_barang']?></td>
                            <td><?=$value['nama_barang']?></td>
                            <td><?=$value['harga_barang']?></td>
                            <td><?=$value['foto_barang']?></td>
                            <td><button name="$value['id_barang']">Edit</button></td>
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
</html>