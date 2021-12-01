<?php
require_once('connection.php');

if (!isset($_SESSION['thx'])) {
    header("Location: search.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <style>
        body {
            background: #d1e6ed;
            margin: 0;
            padding: 0;


        }

        .gambar {
            background-image: url('../img/thankyoupicture.png');
            background-repeat: no-repeat;
            /* background-size: ; */
            height: 100vh;
            width: 100%;
            /* object-fit: cover; */
            background-position: center center;
        }

        @media (max-width: 480px) {
            .gambar {
                height: 100vh;
                background-size: 95%;


            }
            .btnn{
               bottom: 30%;
            }
        }

        .btnn {
            display: flex;
            justify-content: center;
            position: absolute;
            bottom: 20%;
            right: 0;
            left: 0;

        }
    </style>
    <script src="../js/jquery.min.js"></script>

</head>

<body>

    <!-- <h1>Thank You</h1> -->

    <div class="gambar">


        <div class="btnn">
            <button id='backShopping' class="btn btn-primary " style=" margin-right: 10px;">Back To Shopping(8)</button>
            <button id='proceedPay' class="btn btn-primary" style="">Proceed To Pay</button>
        </div>

    </div>



    <script>
        $(() => {
            let time = 8;
            let timer = setInterval(() => {
                time--;
                $('#backShopping').html('Back To Shopping('+time+')');
                if (time == 0) {
                    window.location = "search.php";
                }
            }, 1000);
            $("#backShopping").click(function(){
                clearInterval(timer);
                window.location = "search.php";
            });
            $("#proceedPay").click(function(){
                clearInterval(timer);
                window.location = "history.php";
            });
        });
    </script>

</body>

</html>