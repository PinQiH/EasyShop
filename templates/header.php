<header>
    <div class="logo">
        <a href="index.php">
            <img src="./assets/images/scentselect-logo-white.png" alt="ScentSelect Logo">
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">首頁</a></li>
            <li><a href="products.php">產品</a></li>
            <li><a href="cart.php">購物車</a></li>
            <li><a href="checkout.php">結帳</a></li>
            <?php
            // 檢查用戶是否已登入，如果是，顯示登出按鈕，否則顯示登入和註冊按鈕
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="account.php">帳戶管理</a></li>';
                echo '<li><a href="logout.php">登出</a></li>';
            } else {
                echo '<li><a href="login.php">登入</a></li>';
                echo '<li><a href="register.php">註冊</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>