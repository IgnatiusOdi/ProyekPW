<?php
require_once("connection.php");

$keyword = "";

if (isset($_REQUEST['keyword'])) {
    $keyword = $_GET["keyword"];
    $listBarang = $conn->query("SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%' OR id_kategori in (SELECT id_kategori FROM kategori WHERE nama_kategori LIKE '%$keyword%')")->fetch_all(MYSQLI_ASSOC);
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
    <style>
        .topnav {
            background-color: #333;
            overflow: hidden;
            display: flex;
            /* margin-left: 100px; */
        }


        .topnav .a a {
            justify-content: center;
            margin-right: 10px;
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav div {
            margin-left: 270px;
            display: flex;
        }

        .b{
            padding-top:10px ;
            
        }
        .b input[type=search] {
            border: 1px solid #ccc;
            height: 30px;
            width: 200px;
            border-radius: 5px;
        }
        .b button{
            height: 30px;
            width: 70px;
            border-radius: 5px;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>

<body>

    <div class="topnav">
        <div>
            <div class="a">
                <a href="home.php">Back To Home</a>
                <a href="cart.php">Cart</a>
                <a href="history.php">History</a>
            </div>

            <div class="b">
                <input type="search" id="search">
                <button onclick="search();">Search</button>
            </div>
        </div>

    </div>


    <?php
    if (isset($_REQUEST['keyword'])) {
        echo "<h1 id='keyword'>Keyword '" . $keyword . "'</h1>";
    }
    ?>
    <form action="" method="post">
        <div class="content">
            <?php
            foreach ($listBarang as $key => $value) {
            ?>
                <div class="card" name=<?= $value['id_barang'] ?> onclick=detail(<?= $value['id_barang'] ?>)>
                    <img src=<?= $value['foto_barang'] ?>>
                    <h3><?= $value['nama_barang'] ?></h3>
                    <div>Rp. <?= number_format($value['harga_barang'], 0, '', '.') ?>,-</div>
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
    <script>
        function search() {
            $keyword = $("#search").val();
            $.ajax({
                type: "GET",
                url: "./controller.php",
                data: {
                    "action": "search",
                    "keyword": $keyword
                },
                success: function(response) {
                    $("#keyword").html("Keyword '" + $keyword + "'");
                    $(".content").html(response);
                    location.href = "search.php?keyword=" + $keyword;
                }
            });
        }

        function detail(id) {
            location.href = 'barang.php?id_barang=' + id;
        }
    </script>
</body>

</html>