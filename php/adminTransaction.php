<?php
    require_once('connection.php');

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        header("Location: login.php");
    }

    if (isset($_REQUEST['search'])) {
        $fromDate = $_REQUEST['fromDate'];
        $toDate = $_REQUEST['toDate'];
        header("Location: ?from=$fromDate&to=$toDate");
    }

    if (!isset($_REQUEST['from']) && !isset($_REQUEST['to'])) {
        $fromDate = date('Y-m-d');
        $_SESSION['from'] = $fromDate;
        $toDate = date('Y-m-d');
        $_SESSION['to'] = $toDate;
        $listTransaksi = $conn -> query("SELECT * FROM htrans WHERE DATE(tanggal_transaksi) >= '$fromDate' AND DATE(tanggal_transaksi) <= '$toDate'");
    }

    foreach($listTransaksi as $key => $value) {
        if (isset($_REQUEST['detail-'.$value['id_htrans']])) {
            header("Location: transactionDetail.php?id=".$value['id_htrans']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
</head>
<body>
    <form action="" method="post">
        <h1>Admin Transaction</h1>
        <a href="admin.php">Home</a>
        <a href="adminAdd.php">Add</a>
        Transaction
        <button name="logout">Logout</button><br>
        From: <input type="date" name="fromDate" value="<?=date('Y-m-d')?>">
        to <input type="date" name="toDate" value="<?=date('Y-m-d')?>">
        <button name="search">Search</button>
        <table border=1>
            <tr>
                <td>No.</td>
                <td>Transaction Date</td>
                <td>User</td>
                <td>Total</td>
                <td>Action</td>
            </tr>
            <?php
                $total = 0;
                foreach ($listTransaksi as $key => $value) {
                    echo "<tr>";
                        echo "<td>".($key+1).".</td>";
                        echo "<td>".$value['tanggal_transaksi']."</td>";
                        $user = $listUser[$value['id_users'] - 1];
                        echo "<td>".$user['nama_user']."</td>";
                        echo "<td>Rp. ".number_format($value['total'],0,'','.').",-</td>";
                        echo "<td><button name='detail-".$value['id_htrans']."'>Detail</button></td>";
                    echo "</tr>";
                    $total += $value['total'];
                }
            ?>
        </table>
        <h1>Total: Rp. <?=number_format($total,0,'','.')?>,-</h1>
    </form>
</body>
</html>