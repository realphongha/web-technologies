<div id="header">
    <link rel="stylesheet" href="../../../public/css/style.css"/>
        <?php
        // Neu co thong bao thi in ra:
        if (!is_null($message)){
            if (strlen($message) > 0){
        ?>
        <div class="alert info">
            <span class="closebtn">&times;</span>
                <?php
                echo "<p>" . $message . "</p>";
                ?>
        </div>
        <?php
                }
            }
        ?>
    
    <script>
        var close = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < close.length; i++) {
          close[i].onclick = function(){
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function(){ div.style.display = "none"; }, 600);
          }
        }
    </script>
  
    <div class="hLeft">
        <div class="logo">
            <a href="/"><img src="../public/upload/img/book/logo" 
                             alt="Logo" width="50" height="50"></a>
        </div>
        <div class="logo">
            <h1 style="color: white">Hệ Thống Quản Lý Thư Viện</h1>
        </div>            
    </div>
        
    <div class="hRight">
        <?php
        // Neu chua dang nhap thi hien hop thoai dang nhap:
        if (!isset($_SESSION["current_user"]) || !$_SESSION["current_user"]){
            ?>
            <div class="avatar">
            <form class="login-form"
                  action="/auth/login" method="post">
                <label for="email" style="color: white">Email: </label>
                <input type="text" id="email" name="email">
                &emsp;
                <label for="password" style="color: white">Mật Khẩu: </label>
                <input type="password" id="password" name="password">
                <input type="submit" value="Đăng Nhập">
            </form> 
            </div>
        <?php
        } else {
            // Thong bao chao nguoi dung neu da dang nhap:
            echo "<div class='dropdown'><img stylẹ='float: left' class='avatar dropdown' src='" . unserialize($_SESSION["current_user"])->getImage() ."' alt= 'Avatar' width='50' height='50'>" ;
            echo "<div><a><b>Welcome, " . unserialize($_SESSION["current_user"])->getName() . "!</b></a></div>";
            echo "<div class='dropdown-content'>";
            echo "<a href='/auth/logout' style='color: black'>Đăng xuất</a>";
            echo "<a href='/auth/changePassword' style='color: black'>Đổi mật khẩu</a>";
            echo "</div></div>";
        }
        ?>
    </div>
</div>
