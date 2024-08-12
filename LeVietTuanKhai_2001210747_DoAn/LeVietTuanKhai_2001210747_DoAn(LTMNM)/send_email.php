<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require "vendor/PHPMailer-master/src/Exception.php";
    require "vendor/PHPMailer-master/src/PHPMailer.php";
    require "vendor/PHPMailer-master/src/SMTP.php";

    $mail = new PHPMailer(true);
    try {
        // Thiết lập các thông số của máy chủ SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.elasticemail.com'; // Thay thế bằng máy chủ SMTP của bạn
        $mail->SMTPAuth = true;
        $mail->Username = 'khai0710@gmail.com'; // Thay thế bằng địa chỉ email của bạn
        $mail->Password = '6A28FB6E66F200F705772311A62A4D20CDB7'; // Thay thế bằng mật khẩu email của bạn
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 2525;

        // Thiết lập thông tin người gửi và người nhận
        $mail->setFrom('lvtk07102003@gmail.com', 'Tuan Khai'); // Thay thế bằng địa chỉ email của bạn và tên của bạn
        $mail->addAddress('khai0710@gmail.com');

        // Thiết lập nội dung email
        $mail->isHTML(true);
        $mail->Subject = "Dat lai mat khau";
        $mail->Body = "Nhấp vào liên kết này để đặt lại mật khẩu của bạn:";

        // Gửi email
        $mail->send();
        echo "Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra hộp thư đến của bạn.";
    } catch (Exception $e) {
        echo "Không thể gửi email: {$mail->ErrorInfo}";
    }
?>