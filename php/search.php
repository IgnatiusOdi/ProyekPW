<?php
    require_once("connection.php");

    $keyword = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = $_GET["keyword"];
    }

    $kategori = $conn -> query("SELECT * FROM kategori WHERE nama_kategori LIKE '%$keyword%'") -> fetch_all(MYSQLI_ASSOC);

    $listBarang = $conn -> query("SELECT * FROM barang") -> fetch_all(MYSQLI_ASSOC);

    if (isset($_REQUEST['keyword'])) {
        $idKategori = $kategori[0]['id_kategori'];
        $listBarang = $conn -> query("SELECT * FROM barang WHERE id_kategori=$idKategori") -> fetch_all(MYSQLI_ASSOC);
    }

    foreach ($listBarang as $key => $value) {
        if (isset($_REQUEST["barang-".$value['id_barang']])) {
            echo "<script>alert('CLICKED')</script>";
            // $_SESSION['barang'] = $key;
            // header("Location: barang.php?id_barang=".$value['id_barang']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Badminton Kuy</title>
    <!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick.css" />
    <link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="../css/style.css" /> -->

    <link rel="stylesheet" href="../css/search.css">
</head>

<body>

    <div class="header">
        <a href="home.php">Back To Home</a>
    </div>

    <h1>Keyword "<?=$keyword?>"</h1>
    <input type="search" name="search" id="search">
    <form action="" method="post">
        <div class="content">
            <?php
                foreach($listBarang as $key => $value) {        
            ?>
                <div class="card" name="barang-<?=$value['id_barang']?>">
                    <img src=<?=$value['foto_barang']?>>
                    <h3><?=$value['nama_barang']?></h3>
                    <div>Rp. <?=number_format($value['harga_barang'],0,'','.')?>,-</div>
                </div>
            <?php
                }
            ?>
        </div>
    </form>

    <!-- <div class="section">
      
        <div class="container">
          
            <div class="row">
               
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="../img/rakett.jpg" alt="">
                        </div>
                        <div class="product-body">
                            <p class="product-category">Category</p>
                            <h3 class="product-name"><a href="#">Racket</a></h3>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            
                            <div>stok barang :</div>
                        </div>
                       

                    </div>
                </div>
               
                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="../img/baju.jpg" alt="">
                        </div>
                        <div class="product-body">
                            <p class="product-category">Category</p>
                            <h3 class="product-name"><a href="#">Clothes</a></h3>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="../img/sepatu.jpg" alt="">
                        </div>
                        <div class="product-body">
                            <p class="product-category">Category</p>
                            <h3 class="product-name"><a href="#">Shoes</a></h3>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="product">
                        <div class="product-img">
                            <img src="../img/tas.jpg" alt="">
                        </div>
                        <div class="product-body">
                            <p class="product-category">Category</p>
                            <h3 class="product-name"><a href="#">bags</a></h3>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- shop -->

            <!-- </div> -->
            <!-- /row -->
        <!-- </div> -->
        <!-- /container -->
    <!-- </div> -->




    <!-- <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script> -->
</body>

</html>