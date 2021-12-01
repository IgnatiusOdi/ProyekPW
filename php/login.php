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
                  header("Location: search.php");
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
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <style>
        body{
            margin: 0;
            padding: 0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <!-- <div class="con" style="background-image: url(../img/bglogin.jpg); width: 100%; height: 100%;  background-size: cover;">

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
    </div> -->
    
    <section class="vh-100" >
        
  <div class="container-fluid">
    <div class="row" >
      <div class="col-sm-6 text-black">

        <div class="px-5 ms-xl-4" style="margin-left:0 ; margin-top: 10px; ">
          <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
          <!-- <span class="h1 fw-bold mb-0" >Sign In</span>   -->
        </div>

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

          <form action="" method="post" style="width: 23rem;">

            <h1 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h2>

            <div class="form-outline mb-4">
              <input type="text" id="form2Example18" name="username" class="form-control form-control-lg" placeholder="Username"/>
              <!-- <label class="form-label" for="form2Example18">Username</label> -->
            </div>

            <div class="form-outline mb-4">
              <input type="password" id="form2Example28"  name="password" class="form-control form-control-lg" placeholder="Password"/>
              <br>
              <!-- <label class="form-label" for="form2Example28">Password</label> -->
            </div>

            <div class="pt-1 mb-4">
              <button class="btn btn-info btn-lg btn-block" type="submit" name="login" value="login" style="width: 350px;">Login</button>
            </div>

            <p class="mb-5 pb-lg-2"><a class="text-muted" href="home.php">Back to Home</a></p>
            <p>Don't have an account? <a href="register.php" class="link-info">Register here</a></p>

          </form>

        </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="../img/bgside.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
</section>


</body>
</html>