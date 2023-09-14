<?php
    include('./includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScentSelect</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站標頭 -->
    <?php include 'templates/header.php'; ?>

    <!-- 首頁內容 -->
    <div class="container">
        <h1>ScentSelect</h1>

        <!-- 最新產品列表 -->
        <h2>最新產品</h2>
        <div class="product-list">
            <?php
            // 查詢資料庫以獲取最新的產品，假設按照創建日期降序排序，並且限制顯示5個最新的產品
            $query = "SELECT * FROM products ORDER BY created_at DESC LIMIT 5";

            // 執行查詢
            $result = mysqli_query($connection, $query);

            // 檢查查詢是否成功
            if ($result) {
                // 循環遍歷查詢結果並顯示每個產品的信息
                while ($row = mysqli_fetch_assoc($result)) {
                    $productId = $row['product_id'];
                    $productName = $row['name'];
                    $productDescription = $row['description'];
                    $productImage = $row['product_image'];
                    $imageUrl = $base_url . $productImage;
                    $productPrice = $row['price'];

                    // 在這裡使用提取的產品信息建立產品卡片的HTML
                    echo '<div class="product-card" data-product-id="' . $productId . '">';     
                    echo '<img src="' . $imageUrl . '" alt="' . $productName . '">';
                    echo '<h3>' . $productName . '</h3>';
                    echo '<p>' . $productDescription . '</p>';
                    echo '<p>價格: ' . $productPrice . ' 台幣</p>';
                    echo '</div>';
                }

                // 釋放查詢結果集
                mysqli_free_result($result);
            } else {
                // 查詢失敗時的處理
                echo '無法檢索最新產品。';
            }
            ?>
        </div>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript文件 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
