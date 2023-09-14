<?php
// 開始或恢復會話
session_start();

// 包含資料庫連接設定
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 獲取用戶提交的登入資料
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 在實際應用中，您應該驗證並清理用戶輸入的資料，以防止 SQL 注入等攻擊。

    // 創建 SQL 查詢以從資料庫中檢索用戶資料
    $query = "SELECT * FROM users WHERE email = ?";

    // 使用參數化查詢準備語句
    $stmt = mysqli_prepare($connection, $query);

    // 將用戶提供的電子郵件綁定到查詢參數
    mysqli_stmt_bind_param($stmt, "s", $email);

    // 執行查詢
    mysqli_stmt_execute($stmt);

    // 獲取查詢結果
    $result = mysqli_stmt_get_result($stmt);

    // 檢查查詢結果
    if ($result && mysqli_num_rows($result) === 1) {
        // 提取用戶資料
        $user = mysqli_fetch_assoc($result);

        // 驗證密碼是否匹配
        if (password_verify($password, $user['password'])) {
            // 登入成功
            $_SESSION['user_id'] = $user['user_id'];

            // 重新導向
            header('Location: index.php');
            exit;
        } else {
            // 密碼不匹配
            echo '<script>alert("密碼不正確。請重試。");</script>';
            header('Location: login.php'); // 重新導向到登入頁面
            exit;
        }
    } else {
        // 用戶不存在或電子郵件不匹配
        echo '<script>alert("用戶不存在或電子郵件不正確。請重試。");</script>';
        header('Location: login.php'); // 重新導向到登入頁面
        exit;
    }

    // 釋放查詢準備語句
    mysqli_stmt_close($stmt);
}

// 關閉資料庫連接
mysqli_close($connection);
?>
