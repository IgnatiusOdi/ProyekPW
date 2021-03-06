<?php
require_once('./application/controllers/connection.php');

if (isset($_SESSION['thx'])) {
    unset($_SESSION['thx']);
}

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['user']);
    header("Location: ../../php/login.php");
}

if (!isset($_SESSION['user'])) {
    header("Location: ../../php/login.php");
}

$userNow = $listUser[$_SESSION['user']];
$idUser = $userNow['id_users'];
$listCart = $conn->query("SELECT * FROM cart WHERE id_users='$idUser'")->fetch_all(MYSQLI_ASSOC);
foreach ($listCart as $key => $value) {
    $idCart = $value['id_cart'];
    if (isset($_REQUEST['cancel-' . $idCart])) {
        $idBarang = $value['id_barang'];
        $jumlahPesan = $value['jumlah'];
        $barang = $listBarang[$idBarang - 1];
        $stokBarang = $barang['stok_barang'];
        //RETURN STOK
        // $total = $stokBarang + $jumlahPesan;
        // $sql = "UPDATE `barang` SET `stok_barang`=? WHERE `id_barang`='$idBarang'";
        // $q = $conn->prepare($sql);
        // $q->bind_param("i", $total);
        // $q->execute();
        //DELETE FROM CART
        $sql = "DELETE FROM `cart` WHERE id_cart='$idCart'";
        $q = $conn->prepare($sql);
        $q->execute();
        echo "<script>alert('Barang telah dibatalkan')</script>";
        header("Refresh:0");
    }
}
if (isset($_REQUEST['clearAll'])) {
    $ada = false;
    //CLEAR CART
    foreach ($listCart as $key => $value) {
        $idCart = $value['id_cart'];
        $idBarang = $value['id_barang'];
        $jumlahPesan = $value['jumlah'];
        $barang = $listBarang[$idBarang - 1];
        $stokBarang = $barang['stok_barang'];
        //RETURN STOK
        // $total = $stokBarang + $jumlahPesan;
        // $sql = "UPDATE `barang` SET `stok_barang`=? WHERE `id_barang`='$idBarang'";
        // $q = $conn->prepare($sql);
        // $q->bind_param("i", $total);
        // $q->execute();
        //DELETE FROM CART
        $sql = "DELETE FROM `cart` WHERE id_cart='$idCart'";
        $q = $conn->prepare($sql);
        $q->execute();
        $ada = true;
    }
    if ($ada) {
        echo "<script>alert('Semua Barang Dibatalkan')</script>";
        header("Refresh:0");
    }
}
if (isset($_REQUEST['checkout'])) {
    if (count($listCart) > 0) {
        echo "<script>alert('Hello')</script>";
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
    <script src="../../js/jquery.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<SB-Mid-client-F2b6MIp1NQP2CrFm>"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
   
    <link type="text/css" rel="stylesheet" href="../../css/style.css" />
    <link type="text/css" rel="stylesheet" href="../../css/search.css">
    <link type="text/css" rel="stylesheet" href="../../css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <styLe>
        .row>* {
            width: auto;
            
        }
        .row{
            justify-content:center;
        }

        .btn{
            width: auto;
            margin-left: 5px;
            margin-top: 8px;
            height: 40px;
            font-size: 1.6em;
        }
        
        /* background-color: #d9534f; */
        .btn-warning {
            color: #fff;
            background-color: #d9534f;
            border-color: #d43f3a;
            margin-top: 30px; 
            font-size: 20px;
        }

        .btn-warning:hover {
            color: #fff;
            background-color: #bb2d3b;
            border-color: #b02a37;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
            font-size: 20px;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        body{
            background-color: #d1e6ed;
        }
        @media (max-width: 480px) {
            .gambarr{
                height: 100px;
                width: 100px !important;
            }
        }
        
    </styLe>
</head>

<body>
    <div class="topnav" >
        <div class="row" >
            <div class="a">
                <a href="../../php/home.php" class="">Home</a>
                <a href=<?= "../../php/search.php?page=1&category=" . $_SESSION['category'] . "&itemname=" . $_SESSION['itemname'] ?>>Search</a>
                <a href="" class="active">Cart</a>
                <a href="../../php/history.php">History</a>
                <form action="" method="post">
                    <button class='btn btn-danger' style='background-color: red;' name='logout'>Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- <br> -->

    <table class="table" border=3 style="font-size: 20px; ">
        <tr style="border-bottom: 10px;">
            <td>No.</td>
            <td>Nama Barang</td>
            <td>Jumlah</td>
            <td>Harga</td>
            <td>Action</td>
        </tr>
        <div class="cart">
            <?php
            $item_details = array();
            $hargaTotal = 0;
            foreach ($listCart as $key => $value) {
                echo "<tr>";
                echo "<td>" . ($key + 1) . ".</td>";
                $id = $value['id_barang'];
                $barang = $listBarang[$value['id_barang'] - 1];
                echo "<td><img class='gambarr' style='width: 150px; cursor: pointer;' onclick='detail($id)' src=" . $barang['foto_barang'] . "><br>" . $barang['nama_barang'] . "</td>";
                echo "<td>" . $value['jumlah'] . "</td>";
                echo "<td>Rp. " . number_format($barang['harga_barang'] * $value['jumlah'], 0, '', '.') . ",-</td>";
                echo "<form action='' method='post'>";
                echo "<td><button name='cancel-" . $value['id_cart'] . "'>Cancel</button></td>";
                echo "</form>";
                echo "</tr>";
                $hargaTotal += $value['jumlah'] * $barang['harga_barang'];

                $item1_details = array(
                    'id' => $value['id_barang'],
                    'price' => $barang['harga_barang'],
                    'quantity' => $value['jumlah'],
                    'name' => $barang['nama_barang']
                );
                array_push($item_details, $item1_details);
            }
            ?>
            <input type="hidden" id="user" name="user" value='<?= json_encode($userNow) ?>'>
            <input type="hidden" id="cart_item" name="cart_item" value='<?= json_encode($item_details) ?>'>
            <input type="hidden" id="amount" name="amount" value='<?= $hargaTotal ?>'>
        </div>
    </table>
    <form action="" method="post">
        <button name="clearAll" style="float: left;" class="btn btn-warning" <?= count($listCart) == 0 ? "hidden" : "" ?>>Clear All</button>
        <h3 style="float: right;">Total: Rp. <?= number_format($hargaTotal, 0, '', '.') ?>,-</h3>
        <br><br>
        <button id="pay-button" name="checkout" style="float: right;" class="btn btn-primary" <?= count($listCart) == 0 ? "hidden" : "" ?>>Checkout</button>
    </form>

    <button style='display:none;' id='thankyoubtn'></button>

    <form id="payment-form" method="post" action="./snap/finish">
        <input type="hidden" name="result_type" id="result-type" value=""></div>
        <input type="hidden" name="result_data" id="result-data" value=""></div>
    </form>

    <script>
        function detail(id) {
            location.href = "../../php/barang.php?id_barang=" + id;
        }
    </script>
    <script type="text/javascript">
        $('#pay-button').click(function(event) {
            event.preventDefault();

            var cart_item = $("#cart_item").val();
            var amount = $("#amount").val();
            var user = $("#user").val();

            $.ajax({
                method: 'POST',
                url: './snap/token',
                data: {
                    cart_item: cart_item,
                    amount: amount,
                    user: user
                },
                cache: false,
                success: function(data) {
                    //location = data;
                    console.log('token = ' + data);

                    var resultType = document.getElementById('result-type');
                    var resultData = document.getElementById('result-data');

                    // console.log(resultType);
                    // console.log(resultData);
                    // console.log(userid);

                    function changeResult(type, data) {
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));
                        //resultType.innerHTML = type;
                        //resultData.innerHTML = JSON.stringify(data);
                    }

                    snap.pay(data, {
                        onSuccess: function(result) {
                            changeResult('success', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        },
                        onPending: function(result) {
                            changeResult('pending', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        },
                        onError: function(result) {
                            changeResult('error', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        }
                    });
                }
            });
        });
    </script>


</body>

</html>