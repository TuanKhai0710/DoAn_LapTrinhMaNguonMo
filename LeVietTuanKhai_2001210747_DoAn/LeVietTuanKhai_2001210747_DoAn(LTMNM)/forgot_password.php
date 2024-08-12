<?php
require "class/Database.php";
require "class/Auth.php";
require "inc/init.php";

// Bao gồm thư viện PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/PHPMailer-master/src/Exception.php";
require "vendor/PHPMailer-master/src/PHPMailer.php";
require "vendor/PHPMailer-master/src/SMTP.php";

$conn = new Database();
$pdo = $conn->getConnect();

$emailError = "";
$successMessage = "";
$user = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);  // Loại bỏ khoảng trắng ở đầu và cuối
    // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
    $stmt = $pdo->prepare("SELECT username, password, email FROM user WHERE email = $email");
    $stmt->execute();
    $user = $_SESSION['user_id'];

    if ($user) {
        // Tạo mã thông báo (token) để đặt lại mật khẩu
        $token = bin2hex(random_bytes(15));

        // Lưu token vào cơ sở dữ liệu với email của người dùng
        $stmt = $pdo->prepare("UPDATE user SET reset_token =:token, reset_token_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email =:email");
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        try {
            // Khởi tạo đối tượng PHPMailer
            $mail = new PHPMailer(true);

            // Thiết lập các thông số của máy chủ SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.elasticemail.com'; // Thay thế bằng máy chủ SMTP của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'khai0710@gmail.com'; // Thay thế bằng địa chỉ email của bạn
            $mail->Password = '6A28FB6E66F200F705772311A62A4D20CDB7'; // Thay thế bằng mật khẩu email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Thiết lập thông tin người gửi và người nhận
            $mail->setFrom('lvtk07102003@gmail.com', 'Tuan Khai'); // Thay thế bằng địa chỉ email của bạn và tên của bạn
            $mail->addAddress('khai0710@gmail.com');

            // Thiết lập nội dung email
            $mail->isHTML(true);
            $mail->Subject = "Dat lai mat khau";
            $mail->Body = "Nhap vao lien ket: <a href='http://localhost/LeVietTuanKhai_2001210747_DoAn/reset_password.php?token=$token'>http://localhost/LeVietTuanKhai_2001210747_DoAn/reset_password.php?token=$token</a>";

            // Gửi email
            $mail->send();
            echo "Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư đến của bạn.";
        } catch (Exception $e) {
            echo "Không thể gửi email: {$mail->ErrorInfo}";
        }
    } else {
        $emailError = "Email không tồn tại trong hệ thống.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Quên mật khẩu</h2>
        <form method="post" class="w-50 m-auto">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
                <span class="text-danger fw-bold"><?=$emailError?></span>
            </div>
            <button type="submit" class="btn btn-primary">Gửi email đặt lại mật khẩu</button>
        </form>
        <h4 class="text-success fw-bold"><?=$successMessage?></h4>
    </div>
</body>
</html>
