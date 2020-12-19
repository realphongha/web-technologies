<div id="menu">
    <ul>
        <li><a href="/home/index.php">Trang Chủ</a></li>  
        <?php
        if (isset($_SESSION["current_user"]) && $_SESSION["current_user"]){
            echo "<li><a href='/book/list'>Quản lý sách</a></li>
                  <li><a href='/book/add'>Thêm Sách</a></li>";
            if (unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE){
                echo "<li><a href='/user/list'>Quan ly user</a></li>";
            }
        }
        ?>
    </ul>
</div>
