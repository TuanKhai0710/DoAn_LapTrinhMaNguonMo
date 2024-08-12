<?php
    require "class/Database.php";
    require "class/Product.php";
    require "class/Auth.php";
    require "inc/init.php";
    
    $conn =  new Database();
    $pdo = $conn->getConnect();

    $nameErrors = "";
    $passErrors = "";
    $login_failed = "";

    $name=""; 
    $pass="";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = $_POST['name'];
        $pass = $_POST['pass'];

        $check = Auth::login($pdo, $name, $pass);

        if($check===true) {
            echo "<script>alert('Đăng nhập thành công');</script>";
            $_SESSION['logged_user'] = $name;
            if ($name === "Admin") {
                header("Location: admin/admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }
        else {
            // echo "<script>alert('Đăng nhập thất bại');</script>";
            if(isset($check['nameError']))
                $nameErrors = $check['nameError'];

            if(isset($check['passError']))
                $passErrors = $check['passError'];
            $login_failed = "Đăng nhập thất bại!";
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!-- <link rel="shortcut icon" href="images/favicon.png" type=""> -->

  <title> LeVietTuanKhai_DA_Fastfood </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>
<?php require_once "inc/header.php"?>
</div>

<!-- xử lý form trong cùng 1 file nên kh cần action -->
<h2 class="text-center">Đăng nhập</h2>
<form class="w-50 m-auto" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">UserName</label>
        <input class="form-control" id="name" name="name" value="<?=$name?>">
        <span class="text-danger fw-bold"><?=$nameErrors?></span>
    </div>
    <div class="mb-3">
        <label for="pass" class="form-label">Password</label>
        <input type="password" class="form-control" id="pass" name="pass"  value="<?=$pass?>">
        <span class="text-danger fw-bold"><?=$passErrors?></span>
    </div>
    <h4 class="text-danger fw-bold"><?=$login_failed?></h4>
    <button type="submit" class="btn btn-primary">Đăng nhập</button>
    <a href="forgot_password.php">Quên mật khẩu?</a>  
</form>
<?php require_once "inc/footer.php" ?>
<html></html>