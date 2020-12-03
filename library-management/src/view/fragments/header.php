<div id="header">
    <h1><a href="/">Trang chủ</a></h1>
    <?php
    // Neu co thong bao thi in ra:
    if (!is_null($message)){
        if (strlen($message) > 0){
            echo "<p>" . $message . "</p>";
        }
    }
    // Neu chua dang nhap thi hien hop thoai dang nhap:
    if (!isset($_SESSION["current_user"]) || !$_SESSION["current_user"]){
        ?>
        <form action="/auth/login" method="post">
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Login">
        </form> 
    <?php
    } else {
        // Thong bao chao nguoi dung neu da dang nhap:
        echo "<h2> Hello, " . unserialize($_SESSION["current_user"])->getName() . "!</h2>";
        echo "<p><a href='/auth/logout'>Đăng xuất</a></p>";
    }
    ?>
    <p>---------------</p>
    </br>
</div>

