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

                // 檢查商品庫存是否足夠
                $checkStockQuery = "SELECT stock_quantity FROM products WHERE product_id = ?";
                $checkStmt = mysqli_prepare($connection, $checkStockQuery);
                mysqli_stmt_bind_param($checkStmt, "i", $product_id);
                mysqli_stmt_execute($checkStmt);
                mysqli_stmt_store_result($checkStmt);

                if (mysqli_stmt_num_rows($checkStmt) == 1) {
                    mysqli_stmt_bind_result($checkStmt, $stock_quantity);
                    mysqli_stmt_fetch($checkStmt);

                    if ($stock_quantity >= $quantity) {
                        // 庫存足夠，更新庫存並插入訂單詳情
                        $updateStockQuery = "UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?";
                        $updateStmt = mysqli_prepare($connection, $updateStockQuery);
                        mysqli_stmt_bind_param($updateStmt, "ii", $quantity, $product_id);
                        mysqli_stmt_execute($updateStmt);
                        mysqli_stmt_close($updateStmt);

                        // 插入訂單詳情
                        $insertOrderDetailQuery = "INSERT INTO order_details (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
                        $stmt = mysqli_prepare($connection, $insertOrderDetailQuery);
                        mysqli_stmt_bind_param($stmt, "iiid", $orderId, $product_id, $quantity, $subtotal);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                    } else {
                        // 庫存不足，處理庫存不足的情況
                        echo '<script>alert("商品 ' . $cartItem['name'] . ' 庫存不足。");</script>';
                        header("Location: checkout.php");
                        exit;
                    }
                } else {
                    // 未找到商品，處理商品不存在的情況
                    echo '<script>alert("商品 ' . $cartItem['name'] . ' 不存在。");</script>';
                    header("Location: checkout.php");
                    exit;
                }
                mysqli_stmt_close($checkStmt);
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
