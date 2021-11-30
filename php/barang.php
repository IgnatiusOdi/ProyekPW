<?php
require_once('connection.php');

$barangNow = $listBarang[$_REQUEST['id_barang'] - 1];

if (isset($_REQUEST['search'])) {
    $itemname = $_REQUEST['itemname'];
    $_SESSION['itemname'] = $itemname;

    if (isset($_REQUEST['category'])) {
        $category = $_REQUEST['category'];
        header("Location: search.php?page=1&category=" . $category . "&itemname=" . $itemname);
    } else {
        header("Location: search.php?page=1&itemname=$itemname");
    }
}

if (isset($_REQUEST['addToCart'])) {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    } else {
        $idUser = $_SESSION['user'] + 1;
        $idBarang = $barangNow['id_barang'];
        $jumlahOrder = $_REQUEST['order'];

        //KURANGI DARI STOK
        // $stokBarang = $barangNow['stok_barang'];
        // $sisa = $stokBarang - $jumlahOrder;
        // $sql = "UPDATE `barang` SET `stok_barang`=? WHERE `id_barang`='$idBarang'";
        // $q = $conn->prepare($sql);
        // $q->bind_param("i", $sisa);
        // $q->execute();

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <link rel="stylesheet" href="../css/detailbarang.css">
    <link rel="stylesheet" href="../css/search.css">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
    <!-- <link type="text/css" rel="stylesheet" href="../css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" /> -->
    <!-- <link rel="stylesheet" href="../css/font-awesome.min.css"> -->
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet"> -->
    <script src="../js/jquery.min.js"></script>
    <style>
        .row {
            margin: 0;
            justify-content: center;
        }

        .btn {
            margin-top: 0;
            color: black;
        }
    </style>
</head>

<body>
    <div class="topnav">
        <div class="row">
            <div class="a">
                <a href="home.php">Home</a>
                <a href=<?= "search.php?page=1&category=" . $_SESSION['category'] . "&itemname=" . $_SESSION['itemname'] ?>>Search</a>
                <a href="../midtrans/index.php/snap">Cart</a>
                <a href="history.php">History</a>
            </div>
        </div>
    </div>

    <div style="position: relative;">
        <div>
            <a href=<?= "search.php?page=1&category=" . $_SESSION['category'] . "&itemname=" . $_SESSION['itemname'] ?> class="btn btn-primary" style="display: flex;
            width: 100px;
            height: 40px;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 20px;
            border-radius: 10px;
            color: black;
            z-index: 10;
            ">Back</a>
        </div>

        <div class="container">
            <div class="gambar col-lg-6 col-md-12 col-sm-12">
                <img style="height: 500px; width: 500px;" src=<?= $barangNow['foto_barang'] ?>>
            </div>
            <div class="isi col-lg-6 col-md-12 col-sm-12">
                <div class="judul">
                    <h1 style="font-weight: 600; font-size: 70px;"><?= $barangNow['nama_barang'] ?></h1>
                </div>
                <br>
                <div class="desc">
                    <div style="font-size: 25px;"><?= $barangNow['desc_barang'] ?></div>
                </div>
                <br>
                <div class="harga">
                    <div style="font-size: 25px;">Price : Rp. <?= number_format($barangNow['harga_barang'], 0, '', '.') ?>,-</div>
                </div>
                <br>
                <div class="add">
                    <div style="font-size: 25px;">Sisa stok: <?= $barangNow['stok_barang'] ?></div>
                </div>
                <br>
                <div class="cart" style="display: flex;">
                    <form action="" method="post">
                        <input type="number" name="order" value="<?= $barangNow['stok_barang'] >= 1 ? 1 : 0 ?>" min="<?= $barangNow['stok_barang'] >= 1 ? 1 : 0 ?>" max="<?= $barangNow['stok_barang'] ?>">
                        <?php
                        if ($barangNow['stok_barang'] >= 1)
                            echo "<button class='btn' name='addToCart'>Add to Cart</button>";
                        else
                            echo "<button class='btn' name='addToCart' disabled>Add to Cart</button>";
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function search() {
            $itemname = $("#search").val();
            location.href = "search.php?itemname=" + $itemname;
        }
    </script>
</body>

</html>