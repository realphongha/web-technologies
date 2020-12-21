<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Thêm sách</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../css/style.css" 
              media="screen" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <?php
        require_once __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../fragments/banner.php';        
        require_once __DIR__ . '/../fragments/menu.php';       
        ?>
        
        <div id="content">
            <h1>Thêm tài khoản</h1>
            <div class="addUserForm">
                <form class="fill-form" action="/user/add" method="post" 
                      enctype="multipart/form-data">
                    <label class="form-required" for="email">Email: </label><br>
                    <input type="text" id="email" name="email"><br>
                    <label class="form-required" for="password">Mật khẩu: </label><br>
                    <input type="text" id="password" name="password"><br>
                    <label class="form-required" for="name">Họ tên: </label><br>
                    <input type="text" id="name" name="name"><br>
                    <label class="form-required" for="icNumber">Số CMND/Căn cước:</label><br>
                    <input type='number' id="icNumber" name="icNumber"><br>
                    <label class="form-required" for="phone">Số điện thoại: </label><br>
                    <input type="number" id="phone" name="phone"><br>
                    <label class="form-required" for="dateOfBirth">Ngày sinh: </label><br>
                    <input type="date" id="dateOfBirth" name="dateOfBirth"><br>
                    <label class="form-required" for="address">Địa chỉ: </label><br>
                    <input type="text" id="address" name="address"><br>
                    <?php 
                    if (isset($_SESSION["current_user"]) && 
                                   $_SESSION["current_user"] && 
                                   unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE){
                        echo "<label class='form-required' for='type'>Loại tài khoản (0-admin, 1-thủ thư, 2-thành viên): </label><br>"
                             . "<input type='number' id='type' name='type'><br>";
                    }
                    ?>
                    <label class="form-required" for="image">Ảnh chân dung:</label><br>
                    <input type="file" name="image"><br><br>
                    
                    <input class="green-btn" type="submit" value="Thêm user">
                </form>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>