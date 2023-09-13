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
        // 使用產品ID從資料庫中檢索產品詳情
        // 例如：$product = getProductDetails($_GET['product_id']);

        // 檢查產品是否存在
        if ($product) {
            echo '<h1>' . $product['name'] . '</h1>';
            echo '<p>' . $product['description'] . '</p>';
            echo '<p>價格：$' . $product['price'] . '</p>';
            echo '<p>庫存數量：' . $product['stock_quantity'] . '</p>';

            // 添加到購物車的按鈕
            echo '<form action="add_to_cart.php" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $product['product_id'] . '">';
            echo '<label for="quantity">數量：</label>';
            echo '<input type="number" id="quantity" name="quantity" value="1" min="1" max="' . $product['stock_quantity'] . '">';
            echo '<button type="submit">加入購物車</button>';
            echo '</form>';
        } else {
            echo '<p>產品未找到。</p>';
        }
        ?>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
