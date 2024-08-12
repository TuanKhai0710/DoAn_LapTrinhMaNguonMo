<?php
class Auth {
    public $name, $pass;

    public function __construct($name = "", $pass = "") {
        $this->name = $name;
        $this->pass = $pass;
    }

    public static function getAll($pdo) {
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return $stmt->fetchAll();
        }
    }
    public static function getOneUserByID($pdo, $id) {
        $sql = "SELECT * FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Auth");
            return $stmt->fetch();
        }
    }
    public static function editUser($pdo, $id, $name, $email) {
        $sql = "UPDATE user SET username = :username, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":username", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    public static function deleteUser($pdo, $id) {
        $sql = "DELETE FROM user WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listUser.php");
            exit();
        }
    }

}