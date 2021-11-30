<?php
    require_once('connection.php');

    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
    }

    $idUser = $_SESSION['user'] + 1;
    $listTransaksi = $conn -> query("SELECT * FROM htrans WHERE id_users='$idUser'") -> fetch_all(MYSQLI_ASSOC);

    foreach ($listTransaksi as $key => $value) {
        if (isset($_REQUEST['cancel-'.$value['id_htrans']])) {
            $id = $value['id_htrans'];
            $sql = "UPDATE `payment` SET `status_code`='999',`transaction_status`='canceled' WHERE id='$id'";
            $q = $conn -> prepare($sql);
            $q -> execute();
        } else if (isset($_REQUEST['detail-'.$value['id_htrans']])) {
            header("Location: detailHistory.php?id_transaksi=".$value['id_htrans']);
        }
    }
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
        .topnav .a{
        width: auto;
        }
        .row{
            justify-content:center;
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
                <a href="" class="active">History</a>
            </div>
        </div>
    </div>

    <h1>Transaction History</h1>
    <table class="table" border=1 style="font-size: 20px;">
        <tr>
            <td>No.</td>
            <td>Transaction Date</td>
            <td>Total Price</td>
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
                        echo "<td>";
                        if ($payment['transaction_status'] == 'pending') {
                            echo "Pending";
                        } else if ($payment['transaction_status'] == 'canceled') {
                            echo "Canceled";
                        } else if ($payment['transaction_status'] == 'settlement') {
                            echo "Success";
                        }
                        echo "</td>";
                        echo "<td>";
                            if ($payment['status_code'] == 201) {
                                echo "<a href='https://simulator.sandbox.midtrans.com/bca/va/index' target='_blank'><button>Pay</button></a>";
                                echo "<form action='' method='post'>";
                                echo "<button name='cancel-".$value['id_htrans']."'>Cancel</button>";
                                echo "</form>";
                            }
                        echo "<form action='' method='post'>";
                            echo "<button name='detail-".$value['id_htrans']."'>Detail</button>";
                        echo "</form>";
                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </div>
    </table>
</body>
</html>