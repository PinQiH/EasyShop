// 等待頁面載入完成後執行腳本
window.addEventListener('load', function () {
    // 獲取所有產品卡片
    const productCards = document.querySelectorAll('.product-card');

    // 為每個產品卡片添加點擊事件處理程序
    productCards.forEach(function (card) {
        card.addEventListener('click', function () {
            // 獲取產品卡片中的標題文字
            const productName = card.querySelector('h3').textContent;

            // 顯示確認對話框
            const userConfirmed = confirm('前往產品詳細信息');

            // 如果使用者按下確認按鈕，則導航到產品詳細頁面
            if (userConfirmed) {
                // 導航到產品詳細頁面，這裡是一個示例URL，你需要根據你的項目進行替換
                window.location.href = 'product_details.php?product=' + encodeURIComponent(productName);
            }
        });
    });
});