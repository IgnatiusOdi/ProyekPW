<?php
    require_once('connection.php');

    $barangNow = $listBarang[$_REQUEST['id_barang']];

    if (isset($_REQUEST['addToCart'])) {
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
        } else {
            $idUser = $_SESSION['user'] + 1;
            $idBarang = $barangNow['id_barang'];
            $jumlahOrder = $_REQUEST['order'];

            //TAMBAHKAN KE CART
            $sql = "INSERT INTO `cart`(`id_users`, `id_barang`, `jumlah`) VALUES (?,?,?)";
            $stmt = $conn -> prepare($sql);
            $stmt -> bind_param("iii", $idUser, $idBarang, $jumlahOrder);
            $stmt -> execute();

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
</head>
<body>
    <div class="header">
        <a href="search.php">Back</a>
        <a href="cart.php">Cart</a>
    </div>
    <div>
        <img src=<?=$barangNow['foto_barang']?>>
        <h1><?=$barangNow['nama_barang']?></h1>
        <div><?=$barangNow['desc_barang']?></div>
        <div>Rp. <?=number_format($barangNow['harga_barang'],0,'','.')?>,-</div>
        <div>Sisa stok: <?=$barangNow['stok_barang']?></div>
        <form action="" method="post">
            <input type="number" name="order" value="1" min="1" max="<?=$barangNow['stok_barang']?>"><br>
            <button name="addToCart">Add to Cart</button>
        </form>
    </div>
</body>
</html>