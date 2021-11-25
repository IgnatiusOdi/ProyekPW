<?php
    require_once('connection.php');

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $idUser = $_SESSION['user'] + 1;
    $listCart = $conn -> query("SELECT * FROM cart WHERE id_users='$idUser'") -> fetch_all(MYSQLI_ASSOC);
    $hargaTotal = 0;

    foreach ($listCart as $key => $value) {
        if (isset($_REQUEST['delete-'.$value['id_cart']])) {
            //RETURN STOK

            //DELETE FROM CART


        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <script src="../js/jquery.min.js"></script>
    <style>
        body{
            margin: 0;
            padding: 0;
        }
        .header a {
            justify-content: center;
            margin-right: 10px;
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .header {
            background-color: #333;
            overflow: hidden;
            display: flex;
            position: sticky;
            /* margin-left: 100px; */
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="header">
        <a href="home.php">Home</a>
        <a href="search.php">Search</a>
        <a href="history.php">History</a>
    </div>

    <!-- <br> -->

    <table class="table" border=1>
        <tr>
            <td>No.</td>
            <td>Nama Barang</td>
            <td>Jumlah</td>
            <td>Harga</td>
            <td>Action</td>
        </tr>
        <div class="cart">
            <?php
                foreach ($listCart as $key => $value) {
                    echo "<tr>";
                        echo "<td>".($key + 1).".</td>";
                        $barang = $listBarang[$value['id_barang'] - 1];
                        echo "<td><img src=".$barang['foto_barang']."><br>".$barang['nama_barang']."</td>";
                        echo "<td>".$value['jumlah']."</td>";
                        echo "<td>Rp. ".number_format($barang['harga_barang'],0,'','.').",-</td>";
                        echo "<td><button name='delete-".$value['id_cart']."'>Cancel</button></td>";
                    echo "</tr>";
                    $hargaTotal += $value['jumlah'] * $barang['harga_barang'];
                }
            ?>
        </div>
    </table>
    <h3 style="float: right;">Total: Rp. <?=number_format($hargaTotal,0,'','.')?>,-</h3>
    <br><br>
    <button style="float: right;" class="btn btn-primary">Checkout</button>

    <script>
        function delete(id) {
            $.ajax({
                type:"get",
                url:"./controller.php",
                data:{
                    'action':'deleteFromCart',
                    'id_cart':id
                },
                success:function(response){
                    $(".cart").html(response);
                }
            });
        }
    </script>
</body>

</html>