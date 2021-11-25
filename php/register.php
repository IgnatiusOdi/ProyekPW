<?php
    require_once('connection.php');

    $countUser = count($listUser);
    $nextId = $countUser + 1;

    if (isset($_REQUEST['register'])) {
        $username = $_REQUEST['username'];
        $nama = $_REQUEST['nama'];
        $password = $_REQUEST['password'];
        $confirm = $_REQUEST['confirm'];
        $email = $_REQUEST['email'];
        $nomor = $_REQUEST['nomor'];
        $gender = $_REQUEST['gender'];
        $tanggal = $_REQUEST['tanggal'];
        $kota = $_REQUEST['kota'];
        $foto = $_FILES['foto'];

        if ($username == "") {
            echo "<script>alert('Username harus diisi')</script>";
        } else if ($nama == "") {
            echo "<script>alert('Nama harus diisi')</script>";
        } else if ($password == "") {
            echo "<script>alert('Password harus diisi')</script>";
        } else if ($email == "") {
            echo "<script>alert('Email harus diisi')</script>";
        } else if ($password != $confirm) {
            echo "<script>alert('Password dan Confirm Password tidak sama')</script>";
        } else if ($foto['size'] > 200000) {
            echo "<script>alert('File Size terlalu besar, MAKS. 200KB')</script>";
        } else {
            if ($username == "admin" || $password == "admin") {
                echo "<script>alert('USERNAME / PASSWORD tidak boleh admin')</script>";
            } else {
                $ada = false;
                foreach ($listUser as $key => $value) {
                    if ($value['username'] == $username || $value['email_user']) {
                        $ada = true;
                        break;
                    }
                }

                if ($ada) {
                    echo "<script>alert('USERNAME / EMAIL sudah ada')</script>";
                } else {
                    //ADA FOTO
                    if ($foto['error'] == 0) {
                        $lokasi = "../user/";
                        if (!file_exists($lokasi)) {
                            @mkdir($lokasi);
                        }
                        $namafoto = $nextId;
                        $temp = $foto['tmp_name'];
                        $lokasi .= $namafoto;
                        move_uploaded_file($temp, $lokasi);
                    }

                    //ADD TO USER
                    $sql = "INSERT INTO `user` (`username`, `password`, `email_user`, `nama_user`, `nomor_user`, `gender_user`, `tl_user`, `kota_user`, `foto_user`) VALUES (?,?,?,?,?,?,?,?,?)";
                    $stmt = $conn -> prepare($sql);
                    $stmt -> bind_param("ssssiisss", $username, $password, $email, $nama, $nomor, $gender, $tanggal, $kota, $lokasi);
                    $stmt -> execute();

                    header("Location: login.php");
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
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    
    <div class="center" style="margin-top: 50px ; margin-bottom: 200px;" >
        <form action="" method="post">
        <div class="h1">Create Account</div>
            <input type="text" name="username" placeholder="Username"><br>
            <input type="text" name="nama" placeholder="Nama"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="confirm" placeholder="Confirm Password"><br>
            <input type="email" name="email" placeholder="example@gmail.com"><br>
            <input type="text" name="nomor" maxlength="12" onkeypress="return onlyNumberKey(event)" placeholder="Phone (081801234567)"><br>
            <div class="gender">
                <input type="radio" class="radio" name="gender" value="L">Laki-laki<br>
                <input type="radio" class="radio" name="gender" value="P">Perempuan<br>
            </div>
            <input type="date" class="date" name="tanggal"><br>
            <input type="text" name="kota" placeholder="Surabaya"><br>
            <input type="file" name="foto"><br>
            <button name="register" style="font-size: 20px;">Register</button><br>
            <label>Already have account? <a href="login.php">Let's Login!</a></label>
        </form>
    </div>
</body>
<script>
    function onlyNumberKey(key) {
        var ascii = (key.which) ? key.which : key.keyCode
        if (ascii > 31 && (ascii < 48 || ascii > 57))
            return false;
        return true;
    }
</script>
</html>