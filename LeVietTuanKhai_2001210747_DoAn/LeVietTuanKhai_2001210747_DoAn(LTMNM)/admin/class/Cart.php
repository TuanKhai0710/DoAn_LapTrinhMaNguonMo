<?php
class Cart {
    public $proid, $userid, $qty; 
        public static function getAll($pdo) {
            $sql = "SELECT * FROM cart"; 
            $stmt = $pdo->prepare($sql);
    
            if($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                return $stmt->fetchAll(); // Trả về một mảng rỗng nếu không có kết quả
            }
        }
        public static function getOneCartByID($pdo, $id) {
            $sql = "SELECT * FROM cart WHERE id=:id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                return $stmt->fetch();
            }
        }
        public static function updateStatus($pdo, $id, $status) {
            $sql = "UPDATE cart SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }    
?>
