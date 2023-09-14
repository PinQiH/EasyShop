<?php
// 開始或恢復會話
session_start();

// 檢查是否有購物車會話，如果沒有則創建一個
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// 包含資料庫連接設定
include('includes/config.php');

// 獲取產品詳情的函數，您需要根據您的資料庫結構進行修改
function getProductDetails($productId) {
    global $connection; // 使用全局連接物件

    // 避免 SQL 注入攻擊，請使用參數化查詢
    $query = "SELECT * FROM products WHERE product_id = ?";

    // 使用參數化查詢準備語句
    $stmt = mysqli_prepare($connection, $query);

    // 將產品 ID 綁定到查詢參數
    mysqli_stmt_bind_param($stmt, "i", $productId);

    // 執行查詢
    mysqli_stmt_execute($stmt);

    // 獲取查詢結果
    $result = mysqli_stmt_get_result($stmt);

    // 檢查查詢結果
    if ($result && mysqli_num_rows($result) > 0) {
        // 提取產品詳情
        $product = mysqli_fetch_assoc($result);

        // 釋放查詢準備語句
        mysqli_stmt_close($stmt);

        return $product;
    } else {
        echo '操作失敗';
    }
}

// 檢查是否接收到來自 product_details.php 的 POST 資料
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    // 獲取產品ID和數量
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // 使用 getProductDetails 函數獲取產品詳情
    $product = getProductDetails($productId);

    // 檢查產品是否存在
    if ($product) {
        // 創建一個包含產品詳情和數量的陣列
        $cartItem = array(
            'product_id' => $productId,
            'product_image' => $product['product_image'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        );

        // 將產品添加到購物車
        $_SESSION['cart'][] = $cartItem;

        // 提示用戶產品已成功添加到購物車
        echo '<script>alert("產品已成功添加到購物車。");</script>';
    } else {
        echo '<script>alert("產品未找到。");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物車 - ScentSelect</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 購物車內容 -->
    <div class="container">
        <?php

        // 顯示購物車內容
        if (empty($_SESSION['cart'])) {
            echo '<p>您的購物車是空的。</p>';
        } else {
            echo '<h1>購物車</h1>';
            echo '<form action="checkout.php" method="post">';
            echo '<table>';
            echo '<tr><th></th><th>產品</th><th>數量</th><th>單價</th><th>小計</th><th>操作</th></tr>';
            foreach ($_SESSION['cart'] as $key => $cartItem) {
                $subtotal = $cartItem['price'] * $cartItem['quantity'];
                echo '<tr>';
                echo '<td><a class="link" href="product_details.php?product_id=' . $cartItem['product_id'] . '"><img src="' . $base_url . $cartItem['product_image'] . '" alt="' . $cartItem['name'] . '" class="cart-image"></a></td>';
                echo '<td><a class="link" href="product_details.php?product_id=' . $cartItem['product_id'] . '">' . $cartItem['name'] . '</a></td>';
                echo '<td>' . $cartItem['quantity'] . '</td>';
                echo '<td>$' . $cartItem['price'] . '</td>';
                echo '<td>$' . $subtotal . '</td>';
                echo '<td><button type="button" class="delete-button" data-product-id="' . $cartItem['product_id'] . '">刪除</button></td>';
                echo '</tr>';
            }
            echo '</table>';

            // 結帳按鈕
            echo '<button type="submit" class="checkout-button">結帳</button>';
            echo '</form>';
        }
        ?>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
