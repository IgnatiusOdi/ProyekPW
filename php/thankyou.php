<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <script src="../js/jquery.min.js"></script>
</head>
<body>
    <h1>Thank You</h1>
    <button id='backShopping'>Back To Shopping(8)</button>
    <button id='proceedPay'>Proceed To Pay</button>
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