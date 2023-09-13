<?php
// 數據庫連接設置
$hostname = 'localhost';     // 數據庫主機名稱
$username = 'root'; // 你的數據庫用戶名
$password = 'Root520608'; // 你的數據庫密碼
$database = 'EasyShop'; // 你的數據庫名稱

//圖片儲存位置
$base_url = './assets/';

// 建立數據庫連接
$connection = mysqli_connect($hostname, $username, $password, $database);

// 檢查連接是否成功
if (!$connection) {
    die("數據庫連接失敗：" . mysqli_connect_error());
}

// 設定字符集
mysqli_set_charset($connection, 'utf8');

// 定義全局變數或其他全局設置
$siteName = '易購 (EasyShop)';
$siteURL = 'http://localhost/easyshop'; // 根據你的實際設定進行調整
