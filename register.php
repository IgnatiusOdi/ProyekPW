<?php
    $user = mysqli_connect("localhost", "root", "");
    
    mysqli_close($user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <form action="" method="post">
        <h1>Register</h1>
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username">
        <br>
        <label for="password">Password</label>
        <input type="text" name="password" placeholder="Password">
        <br>
        <input type="submit" name="register" value="Register">
        <label>Already have account? <a href="login.php">Let's Login!</a></label>
    </form>
</body>
</html>