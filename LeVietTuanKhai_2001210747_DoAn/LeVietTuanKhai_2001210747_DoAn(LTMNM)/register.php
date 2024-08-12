<?php
    require "class/Database.php";
    require "class/Product.php";
    require "class/Auth.php";
    // require "inc/init.php";
    $conn =  new Database();
    $pdo = $conn->getConnect();
    
    $nameErrors = "";
    $emailErrors = "";
    $passErrors = "";
    $passconfirmErrors = "";

    $name = "";
    $email = "";
    $pass = "";
    $pass_confirm = "";
    $result = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){ 
        $name = $_POST['name'];
        $email= $_POST['email'];
        $pass =  $_POST['password'];
        $pass_confirm = $_POST['passconfirm'];
        $check = Auth::register($pdo, $name, $pass, $email, $pass_confirm);

        if($check === true){
            // echo "<script>alert('Đăng kí thành công');</script>";
            // header("location:login.php");
            // Auth::register_user($pdo, $name, $pass);
            $result = "Đăng ký thành công! hãy click vào Login để đăng nhập";
        }
        else{
            if(isset($check['nameError']))
                $nameErrors = $check['nameError'];

            if(isset($check['mailError']))
                $emailErrors = $check['mailError'];

            if(isset($check['passError']))
                $passErrors = $check['passError'];

            if(isset($check['passconfError']))
                $passconfirmErrors = $check['passconfError'];
                
        }
    }

?>
</head>
<?php require_once "inc/header.php"?>
</div>

<!-- xử lý form trong cùng 1 file nên kh cần action -->
    <form class="bg-light w-50 m-auto" method="post">
        <h2 class="text-uppercase text-center">Đăng ký tài khoản</h2>
            <div class="mb-2">
                <div class="mb-2">Tên khách hàng</div>
                <input class="w-100" type="text" name="name" value="<?=$name?>" placeholder="Enter your name"/>
                <span class="text-danger fw-bold"><?=$nameErrors?></span>
            </div>
            <div class="mb-2">
                <div class="mb-2">Địa chỉ Email</div>
                <input class="w-100" type="email" name="email"value="<?=$email?>" placeholder="Enter your email address"/>
                <span class="text-danger fw-bold"><?=$emailErrors?></span>
            </div>
            <div class="mb-2">
                <div class="mb-2">Password</div>
                <input class="w-100" type="password" name="password"value="<?=$pass?>" />
                <span class="text-danger fw-bold"><?=$passErrors?></span>
            </div>
            <div class="mb-2">
                <div class="mb-2">Xác nhận password</div>
                <input class="w-100" type="password" name="passconfirm"value="<?=$pass_confirm?>" />
                <span class="text-danger fw-bold"><?=$passconfirmErrors?></span>
            </div>
            <h4 class="text-success"><?=$result?></h4>
            <div class="w-100 text-center">
                <input class="btn btn-success" type="submit" value="Đăng ký" />
                <?php if(!empty($result)):?>
                    <button class="btn btn-success">
                        <a href="login.php" class="text-white text-decoration-none">Login</a>
                    </button>
                <?php endif;?>
            </div>
    </form>
    
<?php require_once "inc/footer.php" ?>
