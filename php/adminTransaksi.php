<?php
    require_once('connection.php');

    if (!isset($_SESSION['admin'])){
        header("Location: login.php");
    }

    if (isset($_REQUEST['logout'])){
        unset($_SESSION['admin']);
        header("Location: login.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
</head>
<body>
    <form action="" method="post">
        <h1>Admin Transaksi</h1>
        <a href="admin.php">Home</a>
        <a href="adminAdd.php">Add Barang</a>
        Transaksi
        <button name="logout">Logout</button><br>
    </form>
</body>
</html>