<?php
    session_start();
    $host = 'localhost';
    $user = 'badmint2_admin';
    $password = 'opoikiair123';
    // $user = 'root';
    // $password = '';
    $database = 'badmint2_proyekpw';
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_errno) {
        die($conn->connect_error);
    }

    $listUser = $conn -> query("SELECT * FROM users") -> fetch_all(MYSQLI_ASSOC);
    $listBarang = $conn -> query("SELECT * FROM barang") -> fetch_all(MYSQLI_ASSOC);
    $listKategori = $conn -> query("SELECT * FROM kategori") -> fetch_all(MYSQLI_ASSOC);
?>