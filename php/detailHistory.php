<?php
    require_once('connection.php');

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $idUser = $_SESSION['user'] + 1;
    $id_htrans = $_REQUEST['id_transaksi'];
    $listHistory = $conn -> query("SELECT * FROM dtrans WHERE id_htrans='$id_htrans'") -> fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
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
        <a href="../midtrans/index.php/snap">Cart</a>
    </div>

    <h1>Transaction ID: <?=$id_htrans?></h1>
    <table class="table" border=1>
        <tr>
            <td>No.</td>
            <td>Tanggal Transaksi</td>
            <td>Jumlah</td>
            <td>Status</td>
            <td colspan=2>Action</td>
        </tr>
        <div class="cart">
            <?php
                foreach ($listTransaksi as $key => $value) {
                    $idPayment = $value['id_payment'];
                    $sql = "SELECT status_code, transaction_status FROM payment WHERE id='$idPayment'";
                    $payment = $conn -> query($sql) -> fetch_assoc();

                    echo "<tr>";
                        echo "<td>".($key + 1).".</td>";
                        echo "<td>".$value['tanggal_transaksi']."</td>";
                        echo "<td>Rp. ".number_format($value['total'],0,'','.').",-</td>";
                        echo "<td>".$payment['transaction_status']."</td>";
                        echo "<td>";
                            if ($payment['status_code'] == 201) {
                                echo "<a href='https://simulator.sandbox.midtrans.com/bca/va/index' target='_blank'><button>Pay</button></a>";
                        echo "<form action='' method='post'>";
                                echo "<button name='cancel-".$value['id_htrans']."'>Cancel</button>";
                            }
                            echo "<button name='detail-".$value['id_htrans']."'>Detail</button>";
                        echo "</td>";
                        echo "</form>";
                    echo "</tr>";
                }
            ?>
        </div>
    </table>
</body>
</html>