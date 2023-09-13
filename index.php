<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>易購 (EasyShop)</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站標頭 -->
    <?php include 'templates/header.php'; ?>

    <!-- 首頁內容 -->
    <div class="container">
        <h1>歡迎來到易購 (EasyShop)</h1>
        <p>簡約質感的購物網站，提供您最優質的購物體驗。</p>

        <!-- 最新產品列表 -->
        <h2>最新產品</h2>
        <div class="product-list">
            <?php
            // 在這裡使用PHP從數據庫檢索並顯示最新的產品
            // 例如：$products = getLatestProducts();
            // 迭代$products並顯示每個產品的信息
            ?>
        </div>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript文件 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
