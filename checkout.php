<?php
include('includes/config.php');

// 開始或恢復會話
session_start();

// 檢查是否存在已登錄的會話變數（例如，user_id）
if (isset($_SESSION['user_id'])) {
    // 用戶已登錄，執行相關操作
    $userLoggedIn = true; 
} else {
    // 用戶未登錄，執行未登錄的操作，例如重定向到登錄頁面
    $userLoggedIn = false; 
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結帳 - 易購 (EasyShop)</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 結帳內容 -->
    <div class="container">
        <h1>結帳</h1>
        <?php
        if (!$userLoggedIn) {
            echo '<p>請先<a href="login.php">登錄</a>或<a href="register.php">註冊</a>以繼續結帳。</p>';
        } else {
            $orderNumber = time(); // 使用時間戳記生成訂單編號
            echo '<h2>訂單編號：' . $orderNumber . '</h2>';

            // 顯示送貨地址表單，用戶可以在這裡填寫送貨地址。
            echo '<h2>送貨地址</h2>';
            echo '<form action="order_process.php" method="post">';
            echo '<div class="form-group">';
            echo '<input type="text" id="delivery-address" name="delivery_address" placeholder="請輸入送貨地址">';
            echo '</div>';

            // 顯示訂單摘要，包括所選商品、總金額和訂單總數。
            echo '<h2>訂單摘要</h2>';
            $totalAmount = 0; // 初始化總金額
            echo '<table>';
            echo '<tr><th></th><th>產品</th><th>數量</th><th>單價</th><th>小計</th></tr>';

            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    $productName = $cartItem['name'];
                    $productPrice = $cartItem['price'];
                    $productQuantity = $cartItem['quantity'];

                    $subtotal = $productPrice * $productQuantity; // 計算小計
                    $totalAmount += $subtotal; // 更新總金額

                    echo '<tr>';
                    echo '<td><img src="' . $base_url . $cartItem['product_image'] . '" alt="' . $cartItem['name'] . '" class="cart-image"></td>';
                    echo '<td>' . $productName . '</td>';
                    echo '<td>$' . $productPrice . '</td>';
                    echo '<td>' . $productQuantity . '</td>';
                    echo '<td>$' . $subtotal . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">購物車是空的。</td></tr>';
            }

            echo '</table>';

            // 顯示總金額和訂單總數
            if (!empty($_SESSION['cart'])) {
                echo '<p>訂單總數：' . count($_SESSION['cart']) . '</p>';
                echo '<p>總金額：$' . $totalAmount . '</p>';
            }
            
            // 顯示支付選項，通常包括信用卡支付、PayPal等選項。
            echo '<h2>支付選項</h2>';
            echo '<div class="payment-info-box">';
            echo '<h2>匯款資訊</h2>';
            echo '<p>請匯款至以下帳號：</p>';
            echo '<p>帳號：1234567890</p>';
            echo '<p>銀行：範例銀行</p>';
            echo '<p>附註：請在匯款附註中提供訂單號碼以便識別您的付款。</p>';
            echo '</div>';

            // 添加提交訂單的按鈕
            echo '<button type="submit" class="checkout-button">提交訂單</button>';
            echo '</form>';
        }
        ?>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
