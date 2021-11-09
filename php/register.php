<?php
    require_once('connection.php');

    $countUser = $conn -> query("SELECT COUNT(*) FROM user") -> fetch_all(MYSQLI_ASSOC);
    $nextId = $countUser[0];
    $nextId = (int)$nextId['COUNT(*)'] + 1;

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
                    echo "<script>alert('USERNAME / EMAIL sudah ada yang punya')</script>";
                } else {
                    //ADA FOTO
                    $lokasi = "";
                    if ($foto['error'] == 0) {
                        $lokasi = "../user/";
                        $namafoto = $nextId;
                        $temp = $foto['tmp_name'];
                        $lokasi .= $namafoto;
                        move_uploaded_file($temp, $lokasi);
                    }

                    //ADD TO DATABASE
                    $sql = "INSERT INTO `user` (`username`, `password`, `email_user`, `nama_user`, `nomor_user`, `gender_user`, `tl_user`, `kota_user`, `foto_user`) VALUES ('$username', '$password', '$email', '$nama', '$nomor', '$gender', '$tanggal', '$kota', '$lokasi')";
                    $stmt = $conn -> prepare($sql);
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
    <link rel="stylesheet" href="../css/style.css">
   
 
</head>
<body  style="background-image: url(../img/back.jpg); "  >
    <div class="regis">
    <form action="" method="post">
        
        <h1>Register</h1>

            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="text" name="username" placeholder="Username"></td>
            </tr>
            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="text" name="nama" placeholder="Nama"></td>
            </tr>
            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="password" name="password" placeholder="Password"></td>
            </tr>
            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="password" name="confirm" placeholder="Confirm Password"></td>
            </tr>
            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="text" name="email" placeholder="example@gmail.com"></td>
            </tr>
            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="text" name="nomor" maxlength="12" onkeypress="return onlyNumberKey(event)" placeholder="081801234567"></td>
            </tr>
            <tr >
                <td style="text-align: right;">Gender</td>
                <td>:</td>
                <td>
                    <br>
                    <input type="radio" name="gender" value="L">Laki-laki<br>
                    <input type="radio" name="radio" value="P">Perempuan<br>
                    <input type="radio" name="gender" value="Lainnya">Lainnya<br>
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">Tanggal Lahir</td>
                <td>:</td>
                <td><input type="date" name="tanggal"></td>
            </tr>
            <tr>
                <td style="text-align: right;"></td>
                <td></td>
                <td><input type="text" name="kota" placeholder="kota"></td>
            </tr>
            <tr>
                <td style="text-align: right;">Foto</td>
                <td>:</td>
                <td><input type="file" name="foto"></td>
            </tr>
            <br>
    

        <input type="submit" name="register" value="Register">
        <br><br>
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