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
    <button id='backShopping'>Back To Shopping</button>
    <button id='proceedPay'>Proceed To Pay</button>
    <script>
        $(() => {
            $("#backShopping").click(function(){
                window.location = "search.php";
            });
            $("#proceedPay").click(function(){
                window.location = "history.php";
            });
            let time = setTimeout(() => {
                window.location = "search.php";
            }, 8000);
        });
    </script>
</body>
</html>