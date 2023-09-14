<?php
    include('./includes/config.php');

    // 開始或恢復會話
    session_start();
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

        <div class="brand-introduction">
            <h2>關於我們</h2>
            <p>ScentSelect 是一個專業的香氛品牌，我們致力於創造獨特且令人難忘的香氛體驗。我們的香水是由最優質的成分製成，並經過精心調配，以確保每一瓶都能帶給您奢華的感受。</p>
            <p>我們的使命是通過我們的香氛作品，讓您散發出自信和魅力，並在每個時刻都感到特別。無論您是在工作、約會還是特殊場合，ScentSelect 的香氛都將成為您的最佳選擇。</p>
            <p>謝謝您選擇 ScentSelect，我們期待為您提供卓越的香氛體驗。</p>
        </div>

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
                    $productImage = $row['product_image'];
                    $imageUrl = $base_url . $productImage;
                    $productPrice = $row['price'];

                    // 在這裡使用提取的產品信息建立產品卡片的HTML
                    echo '<div class="latest-products">';
                    echo '<div class="product-card" data-product-id="' . $productId . '">';     
                    echo '<img src="' . $imageUrl . '" alt="' . $productName . '">';
                    echo '<h3>' . $productName . '</h3>';
                    echo '<p>$' . $productPrice . '</p>';
                    echo '</div></div>';
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
