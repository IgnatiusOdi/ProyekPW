<?php
    require_once("connection.php");

    if (isset($_REQUEST['login'])) {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        if ($username == "jlairlangga@gmail.com" && $password == "opoikiair123") {
            $_SESSION['admin'] = true;
            $keyword = $_REQUEST['keyword'];
            $_SESSION['keyword'] = $keyword;
            header("Location: admin.php?page=1");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="img" style="background-image: url(../img/BG.jpg);">
    <form action="" method="post">
        <div class="left">
        <h1>LOGIN ADMIN</h1>
        <input type="text" name="username" placeholder="Username" />
        <input type="password" name="password" placeholder="Password" />
        <input type="submit" name="login" value="Login">
        </div>
    </form>
</body>
</html>