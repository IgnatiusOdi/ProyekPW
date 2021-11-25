<?php
    require_once('connection.php');

    if (isset($_REQUEST['category'])) {
        $category = $_REQUEST['category'];
        $listBarang = $conn -> query("SELECT * FROM barang WHERE id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%')") -> fetch_all(MYSQLI_ASSOC);
    }

    if (isset($_REQUEST['itemname'])) {
        $itemname = $_REQUEST['itemname'];
        
        if ($itemname != "") {
            if (isset($_REQUEST['category'])) {
                $listBarang = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%' AND id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$category%')") -> fetch_all(MYSQLI_ASSOC);
            } else {
                $listBarang = $conn -> query("SELECT * FROM barang WHERE nama_barang LIKE '%$itemname%'") -> fetch_all(MYSQLI_ASSOC);
            }
        }
    }

    if (isset($_REQUEST['search'])) {
        $itemname = $_REQUEST['itemname'];

        if (isset($_REQUEST['category'])) {
            $category = $_REQUEST['category'];
            header("Location: search.php?category=".$category."&itemname=".$itemname);
        } else {
            header("Location: search.php?itemname=$itemname");
        }
    }

    foreach ($listBarang as $key => $value) {
        if (isset($_REQUEST['addToCart-'.$value['id_barang']])) {
            if (!isset($_SESSION['user'])) {
                header("Location: login.php");
            } else {
                $idUser = $_SESSION['user'] + 1;
                $idBarang = $value['id_barang'];
                $jumlahOrder = 1;
    
                //KURANGI DARI STOK
                $stokBarang = $value['stok_barang'];
                $sisa = $stokBarang - $jumlahOrder;
                $sql = "UPDATE `barang` SET `stok_barang`=? WHERE `id_barang`='$idBarang'";
                $q = $conn -> prepare($sql);
                $q -> bind_param("i", $sisa);
                $q -> execute();
                
                //CARI DI CART BARANG YANG SAMA
                $sql = "SELECT id_barang FROM cart WHERE id_users='$idUser' AND id_barang='$idBarang'";
                $stmt = $conn -> query($sql) -> fetch_assoc();
                if (isset($stmt)) {
                    //JIKA ADA
                    $sql = "SELECT jumlah FROM cart WHERE id_users='$idUser' AND id_barang='$idBarang'";
                    $q = $conn -> query($sql) -> fetch_assoc();
                    $jumlah = $q['jumlah'];
                    $total = $jumlah + $jumlahOrder;
    
                    //UPDATE CART
                    $sql = "UPDATE `cart` SET `jumlah`=? WHERE id_users='$idUser' AND id_barang='$idBarang'";
                    $q = $conn -> prepare($sql);
                    $q -> bind_param("i", $total);
                    $q -> execute();
                } else {
                    //JIKA TIDAK ADA
                    //TAMBAHKAN KE CART
                    $sql = "INSERT INTO `cart`(`id_users`, `id_barang`, `jumlah`) VALUES (?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iii", $idUser, $idBarang, $jumlahOrder);
                    $stmt->execute();
                }
    
                echo "<script>alert('Barang berhasil ditambahkan')</script>";
                header("Refresh:0");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="../css/style.css" />

    <link rel="stylesheet" href="../css/search.css">
    <script src="../js/jquery.min.js"></script>
</head>

<body>

    <section>

        <div class="topnav">
            <div class="row">
                <div class="a">
                    <a href="home.php">Home</a>
                    <a href="cart.php">Cart</a>
                    <a href="history.php">History</a>
                </div>

                <div class="c ">
                    <a href="search.php?category=Rackets" id="Rackets">Rackets</a>
                    <a href="search.php?category=Shoes" id="Shoes">Shoes</a>
                    <a href="search.php?category=Shuttlecocks" id="Cocks">Shuttlecocks</a>
                    <a href="search.php?category=Nets" id="Nets">Nets</a>
                </div>

                <div class="b">
                    <form action="" method="post">
                        <input type="search" id="search" name="itemname" placeholder="Search Item Name">
                        <button name="search">Search</button>
                        <button onclick="location.href = 'search.php';">Clear</button>
                    </form>
                </div>
            </div>

        </div>

        <div class="isi">
            <form action="" method="post">
                <div class="content" style="width: 100%; height: 50%;">
                    <?php
                    foreach ($listBarang as $key => $value) {
                    ?>
                        <div class="card col" onclick=detail(<?= $value['id_barang'] ?>)>
                            <img src=<?= $value['foto_barang'] ?>>
                            <h3 style="text-align: center;"><?= $value['nama_barang'] ?></h3>
                            <div style="margin-bottom: 10px;">Rp. <?= number_format($value['harga_barang'], 0, '', '.') ?>,-</div>
                            <div style="margin-bottom: 10px;">Stok : <?= number_format($value['stok_barang'], 0, '', '.') ?> </div>
                            <?php
                                if ($value['stok_barang'] >= 1)
                                    echo "<button class='btn' name='addToCart-".$value['id_barang']."'>Add to Cart</button>";
                                else
                                    echo "<button class='btn' name='addToCart' disabled>Add to Cart</button>";
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
            <div class="page">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            
        </div>




    </section>


    <!-- <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script> -->
    <script>
        function detail(id) {
            location.href = 'barang.php?id_barang='+id;
        }
    </script>
</body>

</html>