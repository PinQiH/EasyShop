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
        // 檢查用戶是否已登錄，如果未登錄，顯示登錄鏈接或註冊鏈接。
        // 如果已登錄，顯示送貨地址表單、訂單摘要和支付選項。
        if (!$userLoggedIn) {
            echo '<p>請先<a href="login.php">登錄</a>或<a href="register.php">註冊</a>以繼續結帳。</p>';
        } else {
            // 顯示送貨地址表單，用戶可以在這裡填寫送貨地址。

            // 顯示訂單摘要，包括所選商品、總金額和訂單總數。

            // 顯示支付選項，通常包括信用卡支付、PayPal等選項。
        }
        ?>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
