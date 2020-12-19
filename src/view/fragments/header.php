<div id="header">
    <link rel="stylesheet" href="../../../public/css/style.css"/>
  
    <div class="hLeft">
        <div class="logo">
            <img src="../public/upload/img/book/logo" alt="LOGO" width="50" height="50">
        </div>
        <div class="logo">
            <h1>Thư Viện</a></h1>
        </div>            
    </div>
        
    <div class="hRight">
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
        <div class="avatar">
        <form action="/auth/login" method="post">
            <label for="email">Tài Khoản: </label>
            <input type="text" id="email" name="email">
            &emsp;
            <label for="password">Mật Khẩu: </label>
            <input type="password" id="password" name="password">
            <input type="submit" value="Đăng Nhập">
        </form> 
        </div>
    <?php
    } else {
        // Thong bao chao nguoi dung neu da dang nhap:
        echo "<div class='avatar'><img src='../public/upload/img/book/1.jpg' alt= 'Avatar' width='30' height='30'></div>" ;
        echo "<div class='avatar'><h2>" . unserialize($_SESSION["current_user"])->getName() . "</h2>";
        echo "<p><a href='/auth/logout'>Đăng xuất</a></p></div>";
    }
    ?>
    </div>
    
    
</div>    

