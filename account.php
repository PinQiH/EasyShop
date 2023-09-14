<?php
// 檢查用戶是否已登入，如果未登入，重定向到登入頁面
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 包含資料庫連接設定
include('includes/config.php');

// 獲取用戶的個人資料
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($connection, $query);

// 檢查查詢是否成功
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // 若未能找到用戶資料，顯示錯誤信息
    echo "無法檢索用戶資料。";
}

// 獲取用戶的訂單歷史（這部分需要根據你的資料庫結構進行修改）
$query = "SELECT * FROM orders WHERE user_id = $user_id";
$order_result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>帳戶管理 - ScentSelect</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- 網站頂部 -->
    <?php include 'templates/header.php'; ?>

    <!-- 帳戶管理內容 -->
    <div class="container">
        <h1>帳戶管理</h1>

        <!-- 顯示用戶個人資料 -->
        <h2>個人資料</h2>
        <div class="user-profile">
            <p><strong>用戶名稱:</strong> <?php echo $user['username']; ?></p>
            <p><strong>電子郵件:</strong> <?php echo $user['email']; ?></p>
            <!-- 你可以在這裡添加更多的用戶資料顯示 -->
        </div>

        <!-- 顯示訂單歷史 -->
        <h2>訂單歷史</h2>
        <div class="order-history">
            <?php
            if (mysqli_num_rows($order_result) > 0) {
                while ($order = mysqli_fetch_assoc($order_result)) {
                    echo '<form action="order_details.php" method="get">';
                    echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">';
                    echo '<div class="order-card">';
                    echo '<p><strong>訂單編號:</strong> ' . $order['order_id'] . '</p>';
                    echo '<p><strong>訂單日期:</strong> ' . $order['order_date'] . '</p>';
                    echo '<button class="view-details-button">查看詳細</button>';
                    echo '</div>';
                    echo '</form>';
                }
            } else {
                echo '<p>尚未有訂單歷史記錄。</p>';
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
