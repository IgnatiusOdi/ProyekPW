<?php
    require_once("connection.php");

    $action = $_REQUEST['action'];

    if ($action == "search") {
        $keyword = $_REQUEST['keyword'];

        $listBarang = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%'") -> fetch_all(MYSQLI_ASSOC);

        foreach($listBarang as $key => $value) {
            echo "<div class='card' name='".$value['id_barang']."' onclick='detail(".$value['id_barang'].")'>";
                echo "<img src='".$value['foto_barang']."'>";
                echo "<h3>".$value['nama_barang']."</h3>";
                echo "<div>Rp. ".number_format($value['harga_barang'],0,'','.').",-</div>";
            echo "</div>";
        }
    }
?>