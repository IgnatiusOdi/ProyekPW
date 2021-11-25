<?php
    require_once("connection.php");

    if (isset($_REQUEST['login'])) {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        if (isset($_REQUEST['remember'])) {
            $check = $_REQUEST['remember'];
        }
        if ($username == "" && $password == "") {
            echo "<script>alert('Field tidak boleh kosong')</script>";
        } else {
            //ADMIN
            if ($username == "admin" && $password == "admin") {
                $_SESSION['admin'] = true;
                header("Location: admin.php");
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
                    if ($password != $listUser[$index]['password']) {
                        echo "<script>alert('Password Salah!')</script>";
                    } else {
                        $_SESSION['user'] = $index;
                        header("Location: home.php");
                    }
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
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="img" style="background-image: url(../img/BG.jpg);">
    <form action="" method="post">

    <div class="left">
    <h1>Sign up</h1>
    <br>
    
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
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