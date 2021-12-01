<?php
    require_once('connection.php');

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $idUser = $_SESSION['user'] + 1;
    $id_htrans = $_REQUEST['id_transaksi'];
    $listHistory = $conn -> query("SELECT * FROM dtrans WHERE id_htrans='$id_htrans'") -> fetch_all(MYSQLI_ASSOC);

    $q = $conn -> query("SELECT tanggal_transaksi FROM htrans WHERE id_htrans='$id_htrans'") -> fetch_assoc();
    $tanggal = $q['tanggal_transaksi'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>

    <link type="text/css" rel="stylesheet" href="../css/style.css" />
    <link type="text/css" rel="stylesheet" href="../css/search.css" />
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
        body{
            /* background-color: 209, 230, 237; */
            background: #d1e6ed;
        }
        .topnav .a{
        width: auto;
        }
        .row{
            justify-content:center;
        }

        @media (max-width: 480px) {
            .gambar {
                height: 100px;
                width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="topnav">
        <div class="row">
            <div class="a">
                <a href="home.php" class="">Home</a>
                <a href=<?="search.php?page=1&category=".$_SESSION['category']."&itemname=".$_SESSION['itemname']?>>Search</a>
                <a href="../midtrans/index.php/snap" >Cart</a>
                <a href="history.php">History</a>
            </div>
        </div>
    </div>

    <div>
            <a href="history.php" class="btn btn-primary" style="display: flex;
            width: 100px;
            height: 40px;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 20px;
            border-radius: 10px;
            font-size: 20px;
            color: black;
            z-index: 10;
            margin-top: 75px;
            ">Back</a>
        </div>
        
    <div style="position: relative; ">
        

        <div class="container" style="margin-top: 100px;">
            <h1><u>Transaction</u></h1>
            <h4>ID: <?=$id_htrans?></h4>
            <h4>Date-time : <?=date('d F Y - H:i:s', strtotime($tanggal)); ?></h4>
            <table class="table" border=1 style="font-size: 20px;">
                <tr>
                    <td>No.</td>
                    <td>Barang</td>
                    <td>Jumlah</td>
                    <td>Subtotal</td>
                </tr>
                <div class="cart">
                    <?php
                        $total = 0;
                        foreach ($listHistory as $key => $value) {
                            $barang = $listBarang[$value['id_barang'] - 1];
                            $foto = $barang['foto_barang'];
                            echo "<tr>";
                                echo "<td>".($key + 1).".</td>";
                                echo "<td><img class='gambar' src='".$foto." '><br>".$barang['nama_barang']."</td>";
                                echo "<td>".$value['jumlah']."</td>";
                                $harga = $barang['harga_barang'] * $value['jumlah'];
                                echo "<td>Rp. ".number_format($harga,0,'','.').",-</td>";
                            echo "</tr>";

                            $total += $harga;
                        }
                    ?>
                </div>
            </table>
            <h2>Total: Rp.<?=number_format($total,0,'','.')?>,-</h2>
        </div>
    </div>
</body>
</html>