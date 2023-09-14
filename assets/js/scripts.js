// 等待頁面載入完畢後執行腳本
window.addEventListener('load', function () {
    // 獲取所有產品卡片
    const productCards = document.querySelectorAll('.product-card');

    // 為每個產品卡片添加點擊事件處理程序
    productCards.forEach(function (card) {
        card.addEventListener('click', function () {
            // 獲取所選產品的 ID
            const productId = card.getAttribute('data-product-id');

            // 導航到產品詳細頁面並將產品 ID 傳遞作為參數
            window.location.href = 'product_details.php?product_id=' + productId;
        });
    });

    // 獲取所有刪除按鈕
    const deleteButtons = document.querySelectorAll('.delete-button');

    // 為每個刪除按鈕添加點擊事件處理程序
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            // 獲取要刪除的項目的索引
            const productId = button.getAttribute('data-product-id');

            if (confirm('確定要刪除這個項目嗎？')) {
                // 執行刪除操作
                $.ajax({
                    type: 'POST',
                    url: 'remove_item.php', // 您需要指定實際的刪除項目的後端處理頁面
                    data: { product_id: productId },
                    success: function (response) {
                        // 在成功刪除後，更新購物車列表
                        alert('項目已刪除。');
                        // 找到要刪除的行，然後從DOM中刪除
                        const rowToDelete = button.closest('tr');
                        if (rowToDelete) {
                            rowToDelete.remove();
                        }
                    },
                    error: function () {
                        alert('刪除項目時出現錯誤。');
                    }
                });
            }
        });
    });
});