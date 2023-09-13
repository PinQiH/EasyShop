<?php
// 包含資料庫連接設定
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 獲取用戶提交的註冊資料
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 在實際應用中，您應該對用戶輸入的資料進行驗證和清理，以防止 SQL 注入等攻擊。

    // 創建 SQL 查詢以將用戶資料插入到您的資料庫中
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    // 使用參數化查詢準備語句
    $stmt = mysqli_prepare($connection, $query);

    // 使用哈希函數安全地儲存密碼
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 將用戶資料綁定到查詢參數
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

    // 執行查詢
    if (mysqli_stmt_execute($stmt)) {
        // 註冊成功
        echo '<script>alert("註冊成功。請登錄以繼續。");</script>';
        header('Location: login.php'); // 導向登錄頁面
        exit;
    } else {
        // 註冊失敗
        echo '<script>alert("註冊失敗。請稍後再試。");</script>';
        header('Location: register.php'); // 導向註冊頁面
        exit;
    }

    // 釋放查詢準備語句
    mysqli_stmt_close($stmt);
}

// 關閉資料庫連接
mysqli_close($connection);
?>
