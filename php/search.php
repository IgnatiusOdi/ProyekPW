<?php
require_once('connection.php');

if (isset($_SESSION['thx'])) {
    unset($_SESSION['thx']);
}

if (isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
    $_SESSION['category'] = $category;
    $listBarang = $conn->query("SELECT * FROM barang WHERE id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%')")->fetch_all(MYSQLI_ASSOC);
}

if (isset($_REQUEST['itemname'])) {
    $itemname = $_REQUEST['itemname'];
    $_SESSION['itemname'] = $itemname;

    if ($itemname != "") {
        if (isset($_REQUEST['category'])) {
            $listBarang = $conn->query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%' AND id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%')")->fetch_all(MYSQLI_ASSOC);
        } else {
            $listBarang = $conn->query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%'")->fetch_all(MYSQLI_ASSOC);
        }
    }
}

$dataPerHalaman = 8;
$totalData = count($listBarang);
$totalHalaman = ceil($totalData / $dataPerHalaman);
$pageAktif = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$start = ($dataPerHalaman * $pageAktif) - $dataPerHalaman;

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

$listBarang = $conn->query("SELECT * FROM barang LIMIT $start, $dataPerHalaman")->fetch_all(MYSQLI_ASSOC);

if (isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
    $_SESSION['category'] = $category;
    $listBarang = $conn->query("SELECT * FROM barang WHERE id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%') LIMIT $start, $dataPerHalaman")->fetch_all(MYSQLI_ASSOC);
}

if (isset($_REQUEST['itemname'])) {
    $itemname = $_REQUEST['itemname'];
    $_SESSION['itemname'] = $itemname;

    if ($itemname != "") {
        if (isset($_REQUEST['category'])) {
            $listBarang = $conn->query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%' AND id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%') LIMIT $start, $dataPerHalaman")->fetch_all(MYSQLI_ASSOC);
        } else {
            $listBarang = $conn->query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%' LIMIT $start, $dataPerHalaman")->fetch_all(MYSQLI_ASSOC);
        }
    }
}

if (!isset($_SESSION['category']) && !isset($_SESSION['itemname'])) {
    $_SESSION['category'] = '';
    $_SESSION['itemname'] = '';
    header("Location: search.php?page=1&category=&itemname=");
}

if (isset($_REQUEST['search'])) {
    $category = $_REQUEST['kategori'];
    $_SESSION['category'] = $category;

    $itemname = $_REQUEST['itemname'];
    $_SESSION['itemname'] = $itemname;

    header("Location: ?page=1&category=" . $category . "&itemname=" . $itemname);
}

if (isset($_REQUEST['clear'])) {
    $_SESSION['category'] = '';
    $_SESSION['itemname'] = '';
    header("Location: search.php");
}

foreach ($listBarang as $key => $value) {
    if (isset($_REQUEST['addToCart-' . $value['id_barang']])) {
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
        } else {
            $idUser = $_SESSION['user'] + 1;
            $idBarang = $value['id_barang'];
            $jumlahOrder = 1;

            //CARI DI CART BARANG YANG SAMA
            $sql = "SELECT id_barang FROM cart WHERE id_users='$idUser' AND id_barang='$idBarang'";
            $stmt = $conn->query($sql)->fetch_assoc();
            if (isset($stmt)) {
                //JIKA ADA
                $sql = "SELECT jumlah FROM cart WHERE id_users='$idUser' AND id_barang='$idBarang'";
                $q = $conn->query($sql)->fetch_assoc();
                $jumlah = $q['jumlah'];
                $total = $jumlah + $jumlahOrder;

                //UPDATE CART
                $sql = "UPDATE `cart` SET `jumlah`=? WHERE id_users='$idUser' AND id_barang='$idBarang'";
                $q = $conn->prepare($sql);
                $q->bind_param("i", $total);
                $q->execute();
            } else {
                //JIKA TIDAK ADA
                //TAMBAHKAN KE CART
                $sql = "INSERT INTO `cart`(`id_users`, `id_barang`, `jumlah`) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $idUser, $idBarang, $jumlahOrder);
                $stmt->execute();
            }

            echo "<script>alert('Barang berhasil ditambahkan')</script>";
            header("Refresh:0");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
   
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/search.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="../js/jquery.min.js"></script>
    <style>
        .row {
            justify-content: center;
        }
    </style>
   
</head>

<body>
    <section>
        <div class="topnav">
            <div class="row">
                <div class="a">
                    <a href="home.php">Home</a>
                    <a href="" class="active">Search</a>
                    <a href="../midtrans/index.php/snap">Cart</a>
                    <a href="history.php">History</a>
                </div>
            </div>
        </div>

        <div class="isi">
            <div class="kategori">
                <form action="" method="post" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        Category :
                        <select name="kategori">
                            <option value="" <?= $_SESSION['category'] == '' ? 'selected' : '' ?>>All</option>
                            <option value="Rackets" <?= $_SESSION['category'] == 'Rackets' ? 'selected' : '' ?>>Rackets</option>
                            <option value="Shoes" <?= $_SESSION['category'] == 'Shoes' ? 'selected' : '' ?>>Shoes</option>
                            <option value="Shuttlecocks" <?= $_SESSION['category'] == 'Shuttlecocks' ? 'selected' : '' ?>>Shuttlecocks</option>
                            <option value="Nets" <?= $_SESSION['category'] == 'Nets' ? 'selected' : '' ?>>Nets</option>
                        </select>
                    </div>

                    <div>
                        <input type="search" id="search" name="itemname" placeholder="Search Item Name" value='<?= (isset($_SESSION['itemname'])) ? $_SESSION['itemname'] : "" ?>'>
                        <button name="search" class="he">Search</button>
                        <button name="clear" class="he">Clear</button>
                    </div>

                    <!-- <br>
                Sort
                <select name="filter">
                    <option value=""></option>
                    <option value="Nama">Nama</option>
                    <option value="Harga">Harga</option>
                    <option value="Stok">Stok</option>
                </select>
                <select name="ascdesc">
                    <option value=""></option>
                    <option value="ASC">Ascending</option>
                    <option value="DESC">Descending</option>
                </select> -->
                </form>
            </div>

            <form action="" method="post" style="height: fit-content;">
                <div class="content" style="width: 100%; height: 50%; display: flex;">
                    <?php
                    if (count($listBarang) > 0) {
                        foreach ($listBarang as $key => $value) {
                    ?>
                            <div class="card col" style="text-align: center; margin: 1% 3%" onclick=detail(<?= $value['id_barang'] ?>)>
                                <img style="max-width: 90%;" src=<?= $value['foto_barang'] ?>>
                                <h3 style="text-align: center;"><?= $value['nama_barang'] ?></h3>

                                <div class="w-100" style="padding: 0 10px ; ">
                                    <div style="margin-bottom: 10px;">Rp. <?= number_format($value['harga_barang'], 0, '', '.') ?>,-</div>
                                    <div style="margin-bottom: 10px;">Stok : <?= number_format($value['stok_barang'], 0, '', '.') ?> </div>

                                    <div class="w-100" style="justify-content: center; display: flex; ">
                                        <?php
                                        if ($value['stok_barang'] >= 1)
                                            echo "<button class='btn w-100' name='addToCart-" . $value['id_barang'] . "'>Add to Cart</button>";
                                        else
                                            echo "<button class='btn w-100' name='addToCart' disabled>Add to Cart</button>";
                                        ?>
                                    </div>
                                </div>


                            </div>
                    <?php
                        }
                    } else {
                        echo "<h1 style='text-align:center;'>Item Not Found!</h1>";
                    }
                    ?>
                </div>
            </form>
            <div class="page">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        if ($pageAktif > 1) {
                        ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=1<?= (isset($_SESSION['category'])) ? '&category=' . $_SESSION['category'] : ''; ?><?= (isset($_SESSION['itemname'])) ? '&itemname=' . $_SESSION['itemname'] : ''; ?>" aria-label="Previous">
                                    <span aria-hidden="true">First</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="page-link" href="?page=<?= ($pageAktif - 1) ?><?= (isset($_SESSION['category'])) ? '&category=' . $_SESSION['category'] : ''; ?><?= (isset($_SESSION['itemname'])) ? '&itemname=' . $_SESSION['itemname'] : ''; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php
                        }
                        for ($i = $start_num; $i <= $end_num; $i++) {
                            if ($i == $pageAktif) {
                            ?>
                                <li class="page-item"><a style="background-color: red;" class="page-link" href="?page=<?= $i ?><?= (isset($_SESSION['category'])) ? '&category=' . $_SESSION['category'] : ''; ?><?= (isset($_SESSION['itemname'])) ? '&itemname=' . $_SESSION['itemname'] : ''; ?>"><?= $i ?></a></li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item"><a class="page-link" href="?page=<?= $i ?><?= (isset($_SESSION['category'])) ? '&category=' . $_SESSION['category'] : ''; ?><?= (isset($_SESSION['itemname'])) ? '&itemname=' . $_SESSION['itemname'] : ''; ?>"><?= $i ?></a></li>
                            <?php
                            }
                        }
                        if ($pageAktif < $totalHalaman) {
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= ($pageAktif + 1) ?><?= (isset($_SESSION['category'])) ? '&category=' . $_SESSION['category'] : ''; ?><?= (isset($_SESSION['itemname'])) ? '&itemname=' . $_SESSION['itemname'] : ''; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                                <a class="page-link" href="?page=<?= $totalHalaman ?><?= (isset($_SESSION['category'])) ? '&category=' . $_SESSION['category'] : ''; ?><?= (isset($_SESSION['itemname'])) ? '&itemname=' . $_SESSION['itemname'] : ''; ?>" aria-label="Next">
                                    <span aria-hidden="true">Last</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <script>
        function detail(id) {
            location.href = 'barang.php?id_barang=' + id;
        }
    </script>
</body>

</html>