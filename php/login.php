<?php
    require_once("connection.php");

    if (isset($_REQUEST['login'])) {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        
        if ($username == "" && $password == "") {
            echo "<script>alert('Field tidak boleh kosong')</script>";
        } else {
            $index = -1;
            foreach ($listUser as $key => $value) {
                if ($username == $value['username']) {
                    $index = $key;
                    break;
                }
            }

            if ($index == -1) {
                echo "<script>alert('Username belum pernah terdaftar')</script>";
            } else {
                $hashed_password = $listUser[$index]['password'];
                $verify = password_verify($password, $hashed_password);
                if (!$verify) {
                    echo "<script>alert('Password Salah!')</script>";
                } else {
                    $_SESSION['user'] = $index;
                    header("Location: home.php");
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="img" style="background-image: url(../img/BG.jpg);">
    <div class="left">
        <form action="" method="post">
            <h1>Sign In</h1><br>
            <input type="text" name="username" placeholder="Username" autofocus>
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
            <br>
            <br>
            <label>Don't have account? <a href="register.php">Register Now!</a></label>
            <br>
            <br>
            <br>
            <label> <a href="home.php">Back To Home</a></label>
        </form>
    </div>
</body>
</html>