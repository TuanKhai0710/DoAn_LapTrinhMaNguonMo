<?php
require "class/Database.php";
require "inc/init.php";

$conn = new Database();
$pdo = $conn->getConnect();

$error = "";
$success = "";
$user = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password != $confirmPassword) {
        $error = "Mật khẩu không khớp.";
    } else {
        // Kiểm tra tính hợp lệ của token
        $stmt = $pdo->prepare("SELECT id FROM user WHERE reset_token = ? AND reset_token_expire > NOW()");
        

        if ($stmt->execute([$token])) {
            $user_id = $stmt->fetchColumn();
            
            // Cập nhật mật khẩu mới
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE user SET password =:password, reset_token = NULL, reset_token_expire = NULL WHERE id =:id");
            $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $success = "Mật khẩu của bạn đã được đặt lại thành công.";
        } else {
            $error = "Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.";
        }
    }
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $error = "Không có mã thông báo để đặt lại mật khẩu.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center">Đặt lại mật khẩu</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php else: ?>
            <form method="post" class="w-50 m-auto">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
