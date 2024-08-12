<?php
require "class/Product.php";
require "class/Cart.php";
require "class/CartItem.php";
require 'inc/init.php';
require "class/Database.php";

$conn = new Database();
$pdo = $conn->getConnect();

// Giả sử người dùng đã đăng nhập và user_id được xác định
$userid = 2; // Đây là dòng tạm thời, thay thế bằng mã đăng nhập thực tế của bạn

$cartItems = Cart::getAll($pdo, $userid);
$id = "";
$proid = "";
$qty = "";
$i = 1;
$total = 0;
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

<body>
    <div class="container">
        <h1>Cảm ơn bạn đã mua hàng!</h1>
        <p>Đơn hàng của bạn đã được nhận và đang được xử lý.</p>
        <h3>Chi tiết đơn hàng</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $item->name; ?></td>
                            <td><?= $item->price; ?></td>
                            <td><?= $item->Quantity; ?></td>
                            <td><?= $item->price * $item->Quantity; ?></td>
                        </tr>
                        <?php $total += $item->price * $item->Quantity; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Tổng cộng -->
            <div class="cart_total">
                <h4>Tổng cộng: <?= $total; ?></h4>
            </div>
        <p><a href="index.php">Quay lại trang chính</a></p>
    </div>
</body>

</html>
