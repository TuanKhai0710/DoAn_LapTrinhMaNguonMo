<?php
class Product {
    public $id, $name, $price, $description, $image;
    
    public static function getAll($pdo) {
        $sql = "SELECT * FROM product";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
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
    
    public static function addOneProduct($pdo, $name, $description, $price, $image) {
        $sql = "INSERT INTO product(name, price,description, image) VALUES(:name, :price, :description, :image)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }
    public static function pagination($pdo, $limit, $offset) {
        $sql = "SELECT p.id, p.name, p.description, p.price, p.image FROM product p, category c
                WHERE  category_id = c.id ORDER BY category_id LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");

            return $stmt->fetchAll();
        }
    }
    public static function countProduct($pdo) {
        $sql = "SELECT COUNT(*) FROM product";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute()) {           
            return $stmt->fetchColumn();
        }
    }
    public static function getProductsByCategory($pdo, $category)
    {
        if ($category === 'all') {
            // Lấy tất cả các sản phẩm
            $sql = "SELECT * FROM product";
            $stmt = $pdo->prepare($sql);
        } else {
            // Lọc sản phẩm theo danh mục chỉ định
            $sql = "SELECT p.*
                    FROM product p
                    INNER JOIN category c ON p.category_id = c.id
                    WHERE c.name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $category, PDO::PARAM_STR);
        }
        // Thực thi câu lệnh SQL
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product"); 
            return $stmt->fetchAll();
        }
    }
    public static function SearchProduct($pdo, $index)
    {
        $sql = "SELECT * FROM product WHERE name LIKE :index";
        $stmt = $pdo->prepare($sql);

        // Thêm ký tự wildcard (%) vào tham số tìm kiếm
        $index = "%" . $index . "%";
        $stmt->bindParam(':index', $index, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, "Product"); // Trả về tất cả các kết quả dưới dạng mảng kết hợp
        }

        return false; // Trả về false nếu truy vấn thất bại
    }
    public static function SortProductbyPriceDesc($pdo)
    {
        $sql = "SELECT * FROM product ORDER BY price DESC";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
            return $stmt->fetchAll();
        }      
    } 
    public static function SortProductbyPriceAsc($pdo)
    {
        $sql = "SELECT * FROM product ORDER BY price ASC";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
            return $stmt->fetchAll();
        }      
    }   
}