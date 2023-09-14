<?php
// 包含資料庫連接設定
include('includes/config.php');

// 開始或恢復會話
session_start();

// 獲取要顯示的訂單ID，你可以通過URL參數或其他方式獲取它
if (isset($_GET['order_id'])) {
    $orderID = mysqli_real_escape_string($connection, $_GET['order_id']);

    // 查詢訂單信息
    $orderQuery = "SELECT * FROM orders WHERE order_id = $orderID";
    $orderResult = mysqli_query($connection, $orderQuery);

    if ($orderResult && mysqli_num_rows($orderResult) > 0) {
        $order = mysqli_fetch_assoc($orderResult);
        $userID = $order['user_id'];

        // 查詢用戶信息（此處假設你有一個名為 "users" 的表格來存儲用戶信息）
        $userQuery = "SELECT * FROM users WHERE user_id = $userID";
        $userResult = mysqli_query($connection, $userQuery);
        $user = mysqli_fetch_assoc($userResult);

        // 查詢訂單詳細信息
        $orderDetailsQuery = "SELECT od.quantity, p.name, p.description, p.price, p.product_image
                             FROM order_details od
                             INNER JOIN products p ON od.product_id = p.product_id
                             WHERE od.order_id = $orderID";
        $orderDetailsResult = mysqli_query($connection, $orderDetailsQuery);

        // 顯示訂單信息和購物車內容
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>訂單詳細信息</title>
            <link rel="stylesheet" href="assets/css/styles.css">
        </head>
        <body>
            <!-- 網站頂部 -->
            <?php include 'templates/header.php'; ?>

            <div class="container">
                <!-- 顯示訂單信息 -->
                <h1>訂單詳細信息</h1>
                <p><strong>訂單編號：</strong><?php echo $order['order_id']; ?></p>
                <p><strong>訂單日期：</strong><?php echo $order['order_date']; ?></p>
                <p><strong>總金額：</strong>$<?php echo $order['total_amount']; ?></p>
                <p><strong>送貨地址：</strong><?php echo $order['delivery_address']; ?></p>
                <p><strong>付款狀態：</strong><?php echo $order['payment_status']; ?></p>

                <!-- 顯示購物車內容 -->
                <h2>購物車內容</h2>
                <table>
                    <tr>
                        <th></th>
                        <th>產品名稱</th>
                        <th>描述</th>
                        <th>價格</th>
                        <th>數量</th>
                        <th>小計</th>
                    </tr>
                    <?php
                    $totalPrice = 0;

                    while ($row = mysqli_fetch_assoc($orderDetailsResult)) {
                        $productName = $row['name'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $quantity = $row['quantity'];
                        $subtotal = $price * $quantity;
                        $totalPrice += $subtotal;
                        
                        echo '<tr>';
                        echo '<td><img class="cart-image" src="' . $base_url . $row['product_image'] . '" alt="' . $productName . '"></td>';
                        echo '<td>' . $productName . '</td>';
                        echo '<td>' . $description . '</td>';
                        echo '<td>$' . $price . '</td>';
                        echo '<td>' . $quantity . '</td>';
                        echo '<td>$' . $subtotal . '</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="4"><strong>總計：</strong></td>
                        <td><strong>$<?php echo $totalPrice; ?></strong></td>
                    </tr>
                </table>
            </div>

            <!-- 網站底部 -->
            <?php include 'templates/footer.php'; ?>
        </body>
        </html>
        <?php
    } else {
        // 如果找不到訂單，顯示錯誤信息
        echo '<p>找不到該訂單。</p>';
    }
} else {
    // 如果未提供訂單ID，顯示錯誤信息
    echo '<p>未提供訂單ID。</p>';
}
?>
