<?php
include('includes/config.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery_address'])) {
    $orderId = $_POST['order_id'];
    
    $userId = $_SESSION['user_id'];

    $deliveryAddress = $_POST['delivery_address'];

    $totalAmount = $_POST['total_amount'];

    $insertOrderQuery = "INSERT INTO orders (order_id, user_id, delivery_address, total_amount, payment_status) VALUES (?, ?, ?, ?, 0)";

    $stmt = mysqli_prepare($connection, $insertOrderQuery);
    mysqli_stmt_bind_param($stmt, "sids", $orderId, $userId, $deliveryAddress, $totalAmount);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $product_id = $cartItem['product_id'];
                $quantity = $cartItem['quantity'];
                $subtotal = $cartItem['price'] * $quantity;

                $insertOrderDetailQuery = "INSERT INTO order_details (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($connection, $insertOrderDetailQuery);
                mysqli_stmt_bind_param($stmt, "iiid", $orderId, $product_id, $quantity, $subtotal);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }

        unset($_SESSION['cart']);

        header('Location: order_success.php');
        exit;
    } else {
        echo '<script>alert("訂單處理失敗。");</script>';
        header("Location: checkout.php");
    }
} else {
    echo '<script>alert("無效的訂單請求。");</script>';
    header("Location: checkout.php");
}
?>
