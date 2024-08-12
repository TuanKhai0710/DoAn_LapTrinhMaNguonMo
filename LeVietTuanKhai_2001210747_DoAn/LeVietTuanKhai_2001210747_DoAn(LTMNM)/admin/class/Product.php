<?php
class Product {
    public $id, $name, $price, $description, $image;
    
    public static function getAll($pdo) {
        $sql = "SELECT * FROM product";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    public static function getOneProductByID($pdo, $id) {
        $sql = "SELECT * FROM product WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }
    
    public static function addOneProduct($pdo, $name, $price, $description, $image, $category_id) {
        $sql = "INSERT INTO product(name, price, description, image, category_id) VALUES(:name, :price, :description, :image, :category_id)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }

    public static function editProduct($pdo, $id, $name, $price, $description, $image) {
        $sql = "UPDATE product SET name = :name, price = :price, description = :description, image = :image WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    

    public static function deleteProduct($pdo, $id) {
        $sql = "DELETE FROM product WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listProduct.php");
            exit();
        }
    }
}