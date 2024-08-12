<?php
class Cart {
    public $proid, $userid, $qty; 
        public static function getAll($pdo, $userid) {
            $sql = "SELECT p.name, p.price, c.quantity AS Quantity, c.product_id
            FROM cart c
            JOIN product p ON p.id = c.product_id
            WHERE c.user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userid, PDO::PARAM_INT);
    
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
        public static function addOneCart($pdo, $proid, $userid, $qty) {
            $sql = "INSERT INTO cart(product_id, user_id, Quantity, status) 
            VALUES(:product_id, :user_id, :Quantity, 0) 
            ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":product_id", $proid, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $userid, PDO::PARAM_INT);
            $stmt->bindParam(":Quantity", $qty, PDO::PARAM_INT);
    
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                return $stmt->fetch();
            }
        }
    
        public static function emptyCart($pdo, $userid) {
            $sql = "DELETE FROM cart WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":user_id", $userid, PDO::PARAM_INT);
            if($stmt->execute()) {
                return true; // Trả về true nếu xóa thành công
            } else {
                return false; // Trả về false nếu xóa không thành công
            }
        }
    
        public static function removeItem($pdo, $userid, $proid) {
            $sql = "DELETE FROM cart WHERE product_id = :product_id and user_id = :user_id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":user_id", $userid, PDO::PARAM_INT);
            $stmt->bindParam(":product_id", $proid, PDO::PARAM_INT);
            if($stmt->execute()) {
                return true; // Trả về true nếu xóa thành công
            } else {
                return false; // Trả về false nếu xóa không thành công
            } 
        }
    
        public static function updateItem($pdo, $userid, $proid, $qty) {
            $sql = "UPDATE cart SET Quantity = :Quantity WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $pdo->prepare($sql);
        
            $stmt->bindParam(":user_id", $userid, PDO::PARAM_INT);
            $stmt->bindParam(":product_id", $proid, PDO::PARAM_INT);
            $stmt->bindParam(":Quantity", $qty, PDO::PARAM_INT);
        
            if($stmt->execute()) {
                return true; // Trả về true nếu cập nhật thành công
            } else {
                return false; // Trả về false nếu cập nhật không thành công
            } 
        }
    }    
?>
