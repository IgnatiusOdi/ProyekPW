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
</head>
<body>
    <form action="" method="post">
        <h1>Login</h1>
        <table>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="username" placeholder="Username"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="text" name="password" placeholder="Password"></td>
            </tr>
        </table>
        <input type="checkbox" name="remember" value="checked"> Remember Me
        <br>
        <input type="submit" name="login" value="Login">
        <br>
        <label>Don't have account? <a href="register.php">Register Now!</a></label>
    </form>
</body>
</html>