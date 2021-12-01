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
        $foto = $_REQUEST['fotoBarang'];

        if ($nama == "") {
            echo "<script>alert('Nama masih kosong')</script>";
        } else if ($harga < 0) {
            echo "<script>alert('Harga tidak boleh < 0')</script>";
        } else if ($stok < 0) {
            echo "<script>alert('Stok tidak boleh < 0')</script>";
        } else {
            //ADD TO BARANG
            $sql = "INSERT INTO `barang`(`nama_barang`, `desc_barang`, `harga_barang`, `stok_barang`, `id_kategori`, `foto_barang`) VALUES (?,?,?,?,?,?)";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("ssiiis", $nama, $desc, $harga, $stok, $kategori, $foto);
            $stmt -> execute();

            echo "<script>alert('Success Add Item')</script>";
        }
    }

    if (isset($_REQUEST['addBulk'])) {
        $bulk = $_FILES['csv'];
        
        if ($bulk["size"] > 0) {
            $row = 1;
            if (($handle = fopen($bulk['tmp_name'], "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    // echo "<p> $num fields in line $row: <br /></p>\n";
                    $row++;
                    // echo "<pre>";
                    // var_dump($data);
                    // echo "</pre>";
                    $stmt = $conn->prepare("INSERT INTO `barang` (`nama_barang`, `desc_barang`, `harga_barang`, `stok_barang`, `id_kategori`,`foto_barang`) VALUES (?,?,?,?,?,?)");
                    $stmt->bind_param("ssiiis", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
                    $stmt->execute();
                }
                fclose($handle);

                echo "<script>alert('Success Add Bulk')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .content{
            padding: 0 1%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link " aria-current="page" href="admin.php">Home</a>
                    <a class="nav-link active" href="adminAdd.php">Add</a>
                    <a class="nav-link " href="adminTransaction.php">Transaction</a>
                    <button name="logout" class="btn btn-danger">Logout</button>
                </div>
            </div>
        </div>
    </nav>
    <form action="" method="post" enctype="multipart/form-data" class="content">
        <h2>Add Item</h2>
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="namaBarang" placeholder="Nama Barang" style="width: 500px;">
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>:</td>
                    <td>
                        <textarea name="descBarang" cols="100" rows="10" placeholder="Deskripsi Barang" style="resize: none;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>:</td>
                    <td>
                        Rp. <input type="text" name="hargaBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" placeholder="999.999.999" style="text-align: right; width: 100px;"> ,-
                    </td>
                </tr>
                <tr>
                    <td>Stock</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="stokBarang" maxlength="9" onkeypress="return onlyNumberKey(event)" placeholder="123456789" style="text-align: right; width: 100px;">
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>:</td>
                    <td>
                        <?php
                            $check = false;
                            foreach($listKategori as $key => $value) {
                        ?>
                            <input type="radio" name="kategoriBarang" value=<?=$value['id_kategori']?> <?=(!$check) ? 'checked':''?>><?=$value['nama_kategori']?>
                            <br>
                        <?php
                                $check = true;
                            }
                        ?>
                        
                    </td>
                </tr>
                <tr>
                    <td>Picture Link</td>
                    <td>:</td>
                    <td><input type="text" name="fotoBarang" style="width: 700px;" placeholder="Link"></td>
                </tr>
            </table>
            <button name="addBarang" class="btn btn-secondary">Add Barang</button>

            <h2>Bulk Item</h2>
            <table>
                <tr>
                    <td>CSV Barang</td>
                    <td>:</td>
                    <td><input type="file" name="csv"></td>
                </tr>
            </table>
            <button name="addBulk" class="btn btn-primary">Add Bulk</button>
    </form>
</body>
</html>