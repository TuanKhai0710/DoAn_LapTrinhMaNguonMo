<?php
    class Database {
        public function getConnect() {
            $host = "localhost";
            $db = "mydb_admin";
            $username = "Khai_admin";
            $password = "khai754123";

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

            try{
                $pdo = new PDO($dsn, $username, $password);
                if($pdo){
                    return $pdo;
                }
            }catch(PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }
?>