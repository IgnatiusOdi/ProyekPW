<?php
require_once('connection.php');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['admin']);

    unset($_SESSION['from']);
    unset($_SESSION['to']);
    unset($_SESSION['namaUser']);

    header("Location: login.php");
}

if (isset($_REQUEST['search'])) {
    $fromDate = $_REQUEST['fromDate'];
    $_SESSION['from'] = $fromDate;
    $toDate = $_REQUEST['toDate'];
    $_SESSION['to'] = $toDate;
    if (isset($_REQUEST['namaUser'])) {
        $namaUser = $_REQUEST['namaUser'];
        $_SESSION['namaUser'] = $namaUser;
        header("Location: ?from=$fromDate&to=$toDate&user=$namaUser");
    } else {
        header("Location: ?from=$fromDate&to=$toDate");
    }
    header("Refresh:0");
}

if (!isset($_SESSION['namaUser'])) {
    $_SESSION['namaUser'] = '';
}

if (!isset($_REQUEST['from']) && !isset($_REQUEST['to'])) {
    $fromDate = date('Y-m-d');
    $_SESSION['from'] = $fromDate;
    $toDate = date('Y-m-d');
    $_SESSION['to'] = $toDate;
    $listTransaksi = $conn->query("SELECT * FROM htrans WHERE DATE(tanggal_transaksi) >= '$fromDate' AND DATE(tanggal_transaksi) <= '$toDate'");
} else {
    $fromDate = $_SESSION['from'];
    $toDate = $_SESSION['to'];
    if (isset($_SESSION['namaUser'])) {
        $namaUser = $_SESSION['namaUser'];
        $listTransaksi = $conn->query("SELECT * FROM htrans WHERE DATE(tanggal_transaksi) >= '$fromDate' AND DATE(tanggal_transaksi) <= '$toDate' AND id_users IN (SELECT id_users FROM users WHERE username LIKE '%$namaUser%')");
    } else {
        $listTransaksi = $conn->query("SELECT * FROM htrans WHERE DATE(tanggal_transaksi) >= '$fromDate' AND DATE(tanggal_transaksi) <= '$toDate'");
    }
}

foreach ($listTransaksi as $key => $value) {
    if (isset($_REQUEST['detail-' . $value['id_htrans']])) {
        header("Location: transactionDetail.php?id_detail=" . $value['id_htrans']);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .content{
            padding: 1% 1%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link " aria-current="page" href="admin.php">Home</a>
                    <a class="nav-link" href="adminAdd.php">Add</a>
                    <a class="nav-link active " href="adminTransaction.php">Transaction</a>
                    <button name="logout" class="btn btn-danger">Logout</button>
                </div>
            </div>
        </div>
    </nav>
    <form action="" method="post" class="content">
        From: <input type="date" name="fromDate" value="<?= $_SESSION['from'] ?>">
        to <input type="date" name="toDate" value="<?= $_SESSION['to'] ?>"><br>
        Nama User: <input type="text" name="namaUser" placeholder="Search User" value="<?= $_SESSION['namaUser'] ?>">
        <button name="search" class="btn btn-success">Search</button>

        <table border=1 class="table">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Transaction Date</th>
                    <th scope="col">Username</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($listTransaksi as $key => $value) {
                    echo "<tr>";
                    echo "<th scope='row'>" . ($key + 1) . ".</th>";
                    echo "<td>" . $value['tanggal_transaksi'] . "</td>";
                    $user = $listUser[$value['id_users'] - 1];
                    echo "<td>" . $user['username'] . "</td>";
                    echo "<td>Rp. " . number_format($value['total'], 0, '', '.') . ",-</td>";
                    $idPayment = $value['id_payment'];
                    $payment = $conn->query("SELECT * FROM payment WHERE id='$idPayment'")->fetch_assoc();
                    echo "<td>";
                    if ($payment['transaction_status'] == 'pending') {
                        echo "Pending";
                    } else if ($payment['transaction_status'] == 'canceled') {
                        echo "Canceled";
                    } else if ($payment['transaction_status'] == 'settlement') {
                        echo "Success";
                        $total += $value['total'];
                    } else if ($payment['transaction_status'] == 'expire') {
                        echo "Expired";
                    }
                    echo "</td>";
                    echo "<td><button class='btn btn-light' name='detail-" . $value['id_htrans'] . "'>Detail</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>

        </table>
        <h1>Income: Rp. <?= number_format($total, 0, '', '.') ?>,-</h1>
    </form>
</body>

</html>