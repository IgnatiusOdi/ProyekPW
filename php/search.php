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



</head>

<body>

    <section>

        <div class="topnav">
            <div>
                <div class="a">
                    <a href="home.php">Back To Home</a>
                    <a href="cart.php">Cart</a>
                    <a href="history.php">History</a>
                </div>

                <div class="c">
                    <a href="search.php?keyword=Rackets" id="Rackets">Rackets</a>
                    <a href="search.php?keyword=Shoes" id="Shoes">Shoes</a>
                    <a href="search.php?keyword=Shuttlecocks" id="cocks">Shuttlecocks</a>
                    <a href="search.php?keyword=Nets" id="nets">Nets</a>
                </div>

                <div class="b">
                    <input type="search" id="search">
                    <button onclick="search();">Search</button>
                </div>
            </div>

        </div>


        <?php
        if (isset($_REQUEST['keyword'])) {
            // echo "<h1 id='keyword'>Keyword '" . $keyword . "'</h1>";
        }
        ?>

        <div class="isi">
            <form action="" method="post">
                <div class="content" style="width: 100%; height: 50%;">
                    <?php
                    foreach ($listBarang as $key => $value) {
                    ?>
                        <div class="card col" name=<?= $value['id_barang'] ?> onclick=detail(<?= $value['id_barang'] ?>)>
                            <img src=<?= $value['foto_barang'] ?>>
                            <h3 style="text-align: center;"><?= $value['nama_barang'] ?></h3>
                            <div style="margin-bottom: 10px;">Rp. <?= number_format($value['harga_barang'], 0, '', '.') ?>,-</div>
                            <div style="margin-bottom: 10px;">Stok : <?= number_format($value['stok_barang'], 0, '', '.') ?> </div>
                            <button style="margin-bottom: 10px;">Add to Cart</button>
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