<?php
// 開始或恢復會話
session_start();

// 清除用戶的會話數據
session_unset();

// 結束會話
session_destroy();

// 重新導向到登入頁面或其他適當的頁面
header('Location: index.php');
exit;
?>
