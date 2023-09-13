<?php
// 開始或恢復會話
session_start();

// 檢查是否有購物車會話，如果沒有則創建一個
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// 檢查是否收到產品 ID（這是您從前端傳遞的）
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // 確保產品 ID 是有效的數字，避免潛在的安全風險
    if (is_numeric($productId)) {
        // 刪除購物車中的項目
        foreach ($_SESSION['cart'] as $key => $cartItem) {
            if ($cartItem['product_id'] === $productId) {
                unset($_SESSION['cart'][$key]);
                break; // 項目已找到並刪除，退出循環
            }
        }

        // 重新索引陣列以確保連續的鍵
        $_SESSION['cart'] = array_values($_SESSION['cart']);

        // 返回成功消息
        echo 'success';
    } else {
        echo "產品 ID 無效，請提供有效的產品 ID。";
    }
} else {
    echo "未收到產品 ID。";
}
?>