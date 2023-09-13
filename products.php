<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品目錄 - 易購 (EasyShop)</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 產品目錄內容 -->
    <div class="container">
        <h1>產品目錄</h1>
        <div class="product-list">
            <?php
            // 在這裡使用 PHP 從資料庫檢索並顯示產品列表
            // 例如：$products = getProducts();
            // 迭代 $products 並顯示每個產品的資訊
            ?>
        </div>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
