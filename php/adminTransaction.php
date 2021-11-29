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

    if (isset($_REQUEST['from'])) {
        $fromDate = $_REQUEST['from'];
        $toDate = $_REQUEST['to'];
        $listTransaksi = $conn -> query("SELECT * FROM htrans WHERE tanggal_transaksi>='$fromDate' AND tanggal_transaksi<='$toDate'");
    } else {
        $fromDate = date('Y-m-d');
        $toDate = date('Y-m-d');
        header("Location: ?from=$fromDate&to=$toDate");
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
                        $user = $listUser[$value['id_user'] - 1];
                        echo "<td>".$user['nama_user']."</td>";
                        echo "<td>".$value['total']."</td>";
                        echo "<td><button name='detail-".$value['id_htrans']."'></button></td>";
                    echo "</tr>";
                    $total += $value['total'];
                }
                ?>
        </table>
        <h1>Total: Rp. <?=number_format($total,0,'','.')?>,-</h1>
    </form>
</body>
</html>