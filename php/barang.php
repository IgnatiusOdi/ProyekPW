<?php
require_once('connection.php');

$barangNow = $listBarang[$_REQUEST['id_barang']];

$keyword = "";

if (isset($_REQUEST['keyword'])) {
    $keyword = $_GET["keyword"];
    $listBarang = $conn->query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$keyword%')")->fetch_all(MYSQLI_ASSOC);
}

if (isset($_REQUEST['addToCart'])) {
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    } else {
        $idUser = $_SESSION['user'] + 1;
        $idBarang = $barangNow['id_barang'];
        $jumlahOrder = $_REQUEST['order'];

        //TAMBAHKAN KE CART
        $sql = "INSERT INTO `cart`(`id_users`, `id_barang`, `jumlah`) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $idUser, $idBarang, $jumlahOrder);
        $stmt->execute();

        header("Location: cart.php");
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
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
</head>

<body>
    <div class="topnav">
        <div>
            <div class="a">
                <a href="search.php">Back</a>
                <a href="cart.php">Cart</a>
            </div>

            <!-- <div class="c">
                <a href="search.php?keyword=Rackets" id="Rackets">Rackets</a>
                <a href="search.php?keyword=Shoes" id="Shoes">Shoes</a>
                <a href="search.php?keyword=Shuttlecocks" id="cocks">Shuttlecocks</a>
                <a href="search.php?keyword=Nets" id="nets">Nets</a>
            </div> -->

            <div class="b">
                <input type="search" id="search">
                <button onclick="search();">Search</button>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="gambar">
            <img style="height: 500px; width: 500px;" src=<?= $barangNow['foto_barang'] ?>>
        </div>
        <div class="isi">
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
                    <input type="number" name="order" value="1" min="1" max="<?= $barangNow['stok_barang'] ?>">
                    <button class="btn" name="addToCart">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <!-- <div class="container">
        <img src=<?= $barangNow['foto_barang'] ?>>
        <h1><?= $barangNow['nama_barang'] ?></h1>
        <div><?= $barangNow['desc_barang'] ?></div>
        <div>Rp. <?= number_format($barangNow['harga_barang'], 0, '', '.') ?>,-</div>
        <div>Sisa stok: <?= $barangNow['stok_barang'] ?></div>
        <form action="" method="post">
            <input type="number" name="order" value="1" min="1" max="<?= $barangNow['stok_barang'] ?>"><br>
            <button name="addToCart">Add to Cart</button>
        </form>
    </div> -->

    <script>
        function search() {
            $keyword = $("#search").val();
            $.ajax({
                type: "GET",
                url: "./controller.php",
                data: {
                    "action": "search",
                    "keyword": $keyword
                },
                success: function(response) {
                    $("#keyword").html("Keyword '" + $keyword + "'");
                    $(".content").html(response);
                    location.href = "search.php?keyword=" + $keyword;
                }
            });
        }
    </script>

</body>

</html>