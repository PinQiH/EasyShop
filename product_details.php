<?php
// 包含資料庫連接設定
include('includes/config.php');

// 定義函數以獲取產品詳情
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
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品詳情 - 易購 (EasyShop)</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 產品詳情內容 -->
    <div class="container">
        <?php
        // 檢查是否有 GET 參數 product_id
        if (isset($_GET['product_id'])) {
            $productId = $_GET['product_id'];

            // 使用 getProductDetails 函數獲取產品詳情
            $product = getProductDetails($productId);

            // 檢查產品是否存在
            if ($product) {
                echo '<h1>' . $product['name'] . '</h1>';
                echo '<img class="centered-image" src="' . $base_url . $product['product_image'] . '" alt="' . $product['name'] . '">';
                echo '<p>' . $product['description'] . '</p>';
                echo '<p class="price">價格：$' . $product['price'] . '</p>';
                echo '<p class="stock">庫存數量：' . $product['stock_quantity'] . '</p>';

                // 添加到購物車的按鈕
                echo '<form action="cart.php" method="post">';
                echo '<input type="hidden" name="product_id" value="' . $productId . '">';
                echo '<label for="quantity">數量：</label>';
                echo '<input type="number" id="quantity" name="quantity" value="1" min="1" max="' . $product['stock_quantity'] . '">';
                echo '<button type="submit">加入購物車</button>';
                echo '</form>';
            } else {
                echo '<p>產品未找到。</p>';
            }
        } else {
            // 如果未提供 product_id 參數，顯示相應的消息
            echo '未提供產品 ID。';
        }
        ?>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
