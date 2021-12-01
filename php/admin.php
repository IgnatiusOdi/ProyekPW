<?php
    require_once('connection.php');

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        unset($_SESSION['keyword']);
        header("Location: login.php");
    }

    if (isset($_REQUEST['search'])) {
        header("Location: ?page=1");
        $keyword = $_REQUEST['keyword'];
        $_SESSION['keyword'] = $keyword;
    } else {
        $keyword = $_SESSION['keyword'];
    }

    $listBarangPage = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR id_kategori IN (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$keyword%')") -> fetch_all(MYSQLI_ASSOC);

    $dataPerHalaman = 10;
    $totalData = count($listBarangPage);
    $totalHalaman = ceil($totalData/$dataPerHalaman);
    $pageAktif = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    $start = ( $dataPerHalaman * $pageAktif ) - $dataPerHalaman;

    $jumlahTampil = 2;
    if ($pageAktif > $jumlahTampil) {
        $start_num = $pageAktif - $jumlahTampil;
    } else {
        $start_num = 1;
    }
    if ($pageAktif < ($totalHalaman - $jumlahTampil)) {
        $end_num = $pageAktif + $jumlahTampil;
    } else {
        $end_num = $totalHalaman;
    }

    $listBarangPage = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR id_kategori IN (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$keyword%') LIMIT $start, $dataPerHalaman") -> fetch_all(MYSQLI_ASSOC);

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
    <title>Home</title>
    <script src="../js/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
    <form action="" method="post">
        <!-- Home
        <a href="adminAdd.php">Add</a>
        <a href="adminTransaction.php">Transaction</a>
        <button name="logout">Logout</button>
        <h1>Admin Home</h1> -->

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="admin.php">Home</a>
                        <a class="nav-link" href="adminAdd.php">Add</a>
                        <a class="nav-link " href="adminTransaction.php">Transaction</a>
                        <button name="logout" class="btn btn-danger">Logout</button>
                    </div>
                </div>
            </div>
        </nav>

        <span>Total Item: <?=$totalData?></span>
        <h2>List Item</h2>
        <input type="text" name="keyword" id="keyword" placeholder="Search here..." autofocus>
        <button name="search" class="btn btn-success">Search</button><br>
        <?php
            if ($pageAktif > 1) {
                echo "<a href='?page=1'>First</a>";
                echo "<a href='?page=".($pageAktif - 1)."'>&laquo</a>";
            }
            for ($i = $start_num; $i <= $end_num; $i++) {
                if ($i == $pageAktif) {
                    echo "<a href='?page=$i' style='font-weight: bold; color: red;'>$i</a>";
                } else {
                    echo "<a href='?page=$i'>$i</a>";
                }
            }
            if ($pageAktif < $totalHalaman) {
                echo "<a href='?page=".($pageAktif + 1)."'>&raquo</a>";
                echo "<a href='?page=".$totalHalaman."'>Last</a>";
            }
            if ($listBarangPage != null) {
        ?>
            <div id="container">
                <table border=1 class="table">
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
                        foreach ($listBarangPage as $key => $value) :
                    ?>
                            <tr>
                                <td><?=$value['id_barang']?></td>
                                <td><?=$value['nama_barang']?></td>
                                <td style="text-align: right;">Rp. <?=number_format($value['harga_barang'],0,'','.')?>,-</td>
                                <td style="text-align: left;"><?=$value['stok_barang']?></td>
                                <?php
                                    $id = $value['id_kategori'];
                                    $namaKategori = $conn -> query("SELECT * FROM kategori WHERE id_kategori = $id") -> fetch_assoc();
                                    $namaKategori = $namaKategori['nama_kategori'];
                                ?>
                                <td><?=$namaKategori?></td>
                                <td><img src="<?=$value['foto_barang']?>" style="width: 100px; height: 100px;"></td>
                                <td style="text-align: center;"><button class="btn btn-light" name="<?=$value['id_barang']?>">Edit</button></td>
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
    <script>
        function onlyNumberKey(key) {
            var ascii = (key.which) ? key.which : key.keyCode
            if (ascii > 31 && (ascii < 48 || ascii > 57))
                return false;
            return true;
        }
    </script>
</body>
</html>