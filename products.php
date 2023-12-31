<?php
// 包含資料庫連接設定
include('includes/config.php');

// 開始或恢復會話
session_start();

// 定義函數以從資料庫獲取產品列表
function getProducts() {
    global $connection; // 使用全局連接物件

    // 執行 SQL 查詢以獲取產品列表
    $query = "SELECT * FROM products";
    $result = mysqli_query($connection, $query);

    // 檢查查詢結果
    if ($result) {
        $products = array();

        // 將查詢結果轉換為關聯數組
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        // 釋放查詢結果集
        mysqli_free_result($result);

        return $products;
    } else {
        // 查詢失敗時的處理
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品目錄 - ScentSelect</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="./assets/images/scentselect-logo-color.png" type="image/x-icon">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 產品目錄內容 -->
    <div class="container">
        <h1>產品目錄</h1>

        <!-- 搜尋表單 -->
        <form action="products.php" method="GET">
            <input type="text" name="query" placeholder="輸入關鍵字">
            <button type="submit">搜尋</button>
        </form>

        <div id="search-results">
            <!-- 這裡將顯示搜索結果 -->
            <?php
            if (isset($_GET['query'])) {
                // 執行搜索並顯示搜索結果
                $searchQuery = mysqli_real_escape_string($connection, $_GET['query']);
                $query = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";
                $result = mysqli_query($connection, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $imageUrl = $base_url . $row['product_image'];
                        // 顯示搜索結果的產品卡片
                        echo '<div class="product-card" data-product-id="' . $row['product_id'] . '">';
                        echo '<img src="' . $imageUrl . '" alt="' . $row['name'] . '">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<p>' . $row['description'] . '</p>';
                        echo '<p>$' . $row['price'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>未找到符合搜尋條件的產品。</p>';
                }
            } else {
                // 沒有搜尋時，顯示所有商品
                $products = getProducts();

                if ($products && count($products) > 0) {
                    foreach ($products as $product) {
                        // 提取產品資訊
                        $productId = $product['product_id'];
                        $productName = $product['name'];
                        $productDescription = $product['description'];
                        $productImage = $product['product_image'];
                        $productImage = $product['product_image'];
                        $imageUrl = $base_url . $productImage;
                        $productPrice = $product['price'];

                        // 在這裡使用提取的產品信息建立產品卡片的HTML
                        echo '<div class="product-card" data-product-id="' . $productId . '">';
                        echo '<img src="' . $imageUrl . '" alt="' . $productImage . '">';
                        echo '<h3>' . $productName . '</h3>';
                        echo '<p>' . $productDescription . '</p>';
                        echo '<p>$' . $productPrice . '</p>';
                        echo '</div>';
                    }
                } else {
                    // 如果沒有可用的產品，顯示相應的消息
                    echo '目前沒有可用的產品。';
                }
            }
            ?>
        </div>
    </div>

    <!-- 網站底部 -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript檔案 -->
    <script src="assets/js/scripts.js"></script>
</body>
</html>
