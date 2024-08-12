<?php
class Auth {
    public $id, $username, $password;

    public static function login($pdo, $name, $pass) {
        $sql = "SELECT id, password FROM user WHERE username=:username"; 
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":username", $name, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            $user = $stmt->fetch();
            $hashed_password = $user->password;
            $passwd_verify = password_verify($pass, $hashed_password);

            if($passwd_verify) {
                // $_SESSION['logged_user'] = $user->username;
                $_SESSION['user_id'] = $user->id;
                return true;
            }
            else {
                $errorMess = [];
                if(empty($name)) {
                    $errorMess['nameError'] ="Username không được để trống";
                }
    
                if(empty($pass)) {
                    $errorMess['passError']  ="Password không được để trống";
                }
                elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
                    $errorMess['passError']  = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
                }
                return $errorMess;
            }
        }    
    }
    

    public static function register($pdo, $name, $pass, $email, $pass_confirm) {
        $errorMess = [];
        if(empty($name)) {
            $errorMess['nameError'] ="Phải nhập tên khách hàng";
        }

        if(empty($email)) {
            $errorMess['mailError'] ="Phải nhập email";
        }
        elseif(!preg_match("/^\\S+@\\S+\\.\\S+$/", $email)) {
            $errorMess['mailError'] = "Email không hợp lệ!";
        }

        if(empty($pass)) {
            $errorMess['passError'] ="Phải nhập mật khẩu";
        }
        elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $pass)) {
            $errorMess['passError'] = "Password phải có ít nhất 8 ký tự, có ít nhất 1 ký tự hoa, có số và ký tự đặc biệt!";
        }

        if(empty($pass_confirm)) {
            $errorMess['passconfError'] = "Xác nhận mật khẩu không được bỏ trống!";
        }
        elseif($pass_confirm != $pass) {
            $errorMess['passconfError'] = "Xác nhận mật khẩu không đúng!";
        }
        
        if(empty($errorMess)) {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user(username, password, email) VALUES(:username, :password, :email)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":username", $name, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
                // return $stmt->fetch();
                return true;
            }
        }
        else{
            return $errorMess;
        }
    }

    public static function register_user($pdo, $name, $pass) {
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(username, password) VALUES(:username, :password)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":username", $name, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return $stmt->fetch();
        }
    }

    public function logout() {
        unset($_SESSION['logged_user']);
    }



    public function restrictAccess() {
        if(!isset( $_SESSION['logged_user'])){
            die('Ban can phai dang nhap');
            exit; // dừng việc thực hiện mã PHP tiếp theo
        }
    }
}