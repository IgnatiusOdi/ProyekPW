<?php
    session_start();
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'proyekpw';
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_errno) {
        die($conn->connect_error);
    }

    $listUser = $conn -> query("SELECT * FROM user") -> fetch_all(MYSQLI_ASSOC);
    $listBarang = $conn -> query("SELECT * FROM barang") -> fetch_all(MYSQLI_ASSOC);
    $listKategori = $conn -> query("SELECT * FROM kategori") -> fetch_all(MYSQLI_ASSOC);

?>