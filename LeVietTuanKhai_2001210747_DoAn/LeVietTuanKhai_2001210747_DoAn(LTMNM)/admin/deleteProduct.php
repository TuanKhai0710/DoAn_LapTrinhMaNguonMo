<?php
    require "class/Database.php";
    require "class/Product.php";
    require "class/Auth.php";
    require "inc/init.php";

    $nameErrors = "";
    $desErrors = "";
    $priceErrors = "";
    $imageErrors = "";

    $id = "";
    $name = "";
    $des = "";
    $price = "";
    $image = "";

    $auth = new Auth();
    //$auth->restrictAccess();

    $conn = new Database();
    $pdo = $conn->getConnect();
    $product = Product::getOneProductByID($pdo, $_GET["Id"]);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $des = $_POST['des'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        
        if(empty($name)) {
            $nameErrors = "Phải nhập tên";
        }
        if(empty($des)) {
            $desErrors = "Phải nhập mô tả";
        }
        if(empty($price)) {
            $priceErrors = "Phải nhập giá";
        } elseif($price % 1000 != 0){
            $priceErrors = "Giá phải chia hết cho 1000";
        }
        
        if(!$nameErrors && !$desErrors && !$priceErrors) {
            $conn = new Database();
            $pdo = $conn->getConnect();
            Product::deleteProduct($pdo, $id);
            
            header("Location: listProduct.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Charts</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php require "inc/sidebar.php"; ?>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php require "inc/topbar.php"; ?>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h2 class="text-center">Xóa sản phẩm</h2>
                    <form class="w-50 m-auto" method="post" onsubmit="return confirmDeletion();">
                        <div class="mb-3">
                            <label for="id" class="form-label">Id</label>
                            <input class="form-control" id="id" name="id" readonly value="<?=$product->id?>">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên SP</label>
                            <input class="form-control" id="name" name="name" readonly value="<?=$product->name?>">
                            <span class="text-danger fw-bold"><?=$nameErrors?></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input class="form-control" id="price" name="price" readonly value="<?=$product->price?>">
                            <span class="text-danger fw-bold"><?=$priceErrors?></span>
                        </div>
                        <div class="mb-3">
                            <label for="textarea" class="form-label">Description</label>
                            <input class="form-control" id="des" name="des" readonly value="<?=$product->description?>">
                            <span class="text-danger fw-bold"><?=$desErrors?></span>
                        </div>
                        <div class="mb-3">
                            <label for="textarea" class="form-label">Image</label>
                            <input class="form-control" id="image" name="image" value="<?=$image?>">
                            <span class="text-danger fw-bold"><?=$imageErrors?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Xóa SP</button>
                    </form>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
    <script>
    function confirmDeletion() {
        return confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
    }
    </script>
</body>
</html>
