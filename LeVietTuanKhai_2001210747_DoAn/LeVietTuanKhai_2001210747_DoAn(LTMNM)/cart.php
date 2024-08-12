<?php
$title = 'Cart page';
require "class/Product.php";
require "class/Cart.php";
require "class/CartItem.php";
require 'inc/init.php';
require "class/Database.php";

$conn = new Database();
$pdo = $conn->getConnect();

// Giả sử người dùng đã đăng nhập và user_id được xác định
$userid = 2; // Đây là dòng tạm thời, thay thế bằng mã đăng nhập thực tế của bạn

$cartItems = Cart::getAll($pdo, $userid);
$id = "";
$proid = "";
$qty = "";
$i = 1;
$total = 0;

// Xử lý các hành động của giỏ hàng theo phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['proid'];
    $userid = $_SESSION['user_id'];
    if (isset($_POST['Empty'])) {
        $removeAll = Cart::emptyCart($pdo, $userid);
    } elseif (isset($_POST['Remove'])) {
        $remove = Cart::removeItem($pdo, $userid, $id);
    } elseif (isset($_POST['update'])) {
        $proid = $_POST['proid'];
        $qty = $_POST['qty'];
        $update = Cart::updateItem($pdo, $userid, $proid, $qty);
    } 
    if (isset($_POST['checkout'])) {
        header("Location: thankyou.php");
        exit();
    }
    header("location:cart.php");
    exit();
}
?>

<?php require_once "inc/header.php"?>
</div>
    <!-- cart section -->
    <section class="cart_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>My Cart</h2>
            </div>
            <div class="cart_container">
                <form method="post" action="cart.php">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $item->name; ?></td>
                                    <td><?= $item->price; ?></td>
                                    <td><input type="number" name="qty" value="<?= $item->Quantity; ?>" min="1"></td>
                                    <td><?= $item->price * $item->Quantity; ?></td>
                                    <td>
                                        <button type="submit" name="Remove" value="Remove" class="btn btn-danger">Remove</button>
                                        <button type="submit" name="update" value="Update" class="btn btn-primary">Update</button>
                                        <input type="hidden" name="proid" value="<?= $item->product_id; ?>">
                                    </td>
                                </tr>
                                <?php $total += $item->price * $item->Quantity; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="cart_total">
                        <h4>Total: <?= $total; ?></h4>
                    </div>
                    <button type="submit" name="Empty" value="Empty" class="btn btn-danger">Empty Cart</button>
                    </br>
                    <div class="payment-form">
                        <h3>Thông tin thanh toán</h3>
                        <div class="form-group">
                            <label for="fullname">Họ và tên:</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Số điện thoại:</label>
                            <input type="phone" id="phone" name="phone" class="form-control" required pattern="[0-9]{10}" title="Vui lòng nhập số điện thoại gồm 10 chữ số">
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>
                            <textarea id="address" name="address" class="form-control" required></textarea>
                        </div>
                        <button type="submit" name="checkout" class="btn btn-primary">Thanh toán</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- end cart section -->

    <!-- footer section -->
    <?php require_once "inc/footer.php"?>
    <!-- footer section -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>
