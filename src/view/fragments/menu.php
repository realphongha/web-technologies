<div id="menu">
    <ul class="navi-bar">
        <li><a href="/home/index.php">Trang Chủ</a></li>  
        <?php
        if (isset($_SESSION["current_user"]) && $_SESSION["current_user"]){
            echo "<li><a href='/book/list'>Quản lý sách</a></li>";
            echo "<li><a href='/user/list'>Quản lý tài khoản</a></li>";
            echo "<li><a href='/bbook/list'>Quản lý mượn sách</a></li>";
        } else {
            echo "<li><a href='/book/list'>Danh sách sách</a></li>";
        }
        ?>
    </ul>
</div>
