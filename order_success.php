<?php
// 開始或恢復會話
session_start();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3;url=index.php">
    <title>訂單提交成功 - ScentSelect</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="./assets/images/scentselect-logo-color.png" type="image/x-icon">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 訂單提交成功內容 -->
    <div class="container">
        <h1>訂單提交成功</h1>
        <p>感謝您的訂購！您的訂單已成功提交。</p>
        <p>請稍等，我們將在 3 秒內為您跳轉回首頁。</p>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
