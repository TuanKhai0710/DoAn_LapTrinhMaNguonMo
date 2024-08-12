<?php
class Category {
    public $id, $name;

    public static function getAll($pdo) {
        $sql = "SELECT id, name FROM category";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetchAll();
        }
    }

    public static function addOneCategory($pdo, $name) {
        $sql = "INSERT INTO category(name) VALUES(:name)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetch();
        }
    }
}
?>