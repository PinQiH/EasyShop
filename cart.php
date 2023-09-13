<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物車 - 易購 (EasyShop)</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 購物車內容 -->
    <div class="container">
        <h1>購物車</h1>
        <?php
        // 檢查購物車是否為空
        if (empty($_SESSION['cart'])) {
            echo '<p>您的購物車是空的。</p>';
        } else {
            // 顯示購物車內容
            echo '<table>';
            echo '<tr><th>產品</th><th>數量</th><th>單價</th><th>小計</th><th>操作</th></tr>';
            foreach ($_SESSION['cart'] as $product) {
                // 這裡需要使用PHP代碼來顯示購物車中每個商品的信息，包括產品名稱、數量、單價、小計，以及刪除選項。
            }
            echo '</table>';
        }
        ?>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
