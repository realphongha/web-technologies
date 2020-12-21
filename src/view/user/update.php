<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Sửa tài khoản</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../css/style.css" media="screen" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <?php
        require_once __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../fragments/banner.php';        
        require_once __DIR__ . '/../fragments/menu.php';       
        ?>
        
        <div id="content">
            <h1>Sửa tài khoản</h1>
            <div id="updateUserForm">
                <form class="fill-form" action="<?php echo "/user/update?id=" . strval($variables->getUserId()); ?>" 
                      method="post" enctype="multipart/form-data">
                    <label for="email">Email: </label><br>
                    <input type="text" id="email" name="email" value="<?php echo $variables->getEmail(); ?>"><br>
                    <label for="password">Mật khẩu: </label><br>
                    <input type="text" id="password" name="password" 
                           placeholder="Để trống nếu không muốn thay đổi"
                           value="<?php echo $variables->getPassword(); ?>"><br>
                    <label for="name">Họ tên: </label><br>
                    <input type="text" id="name" name="name" value="<?php echo $variables->getName(); ?>"><br>
                    <label for="icNumber">Số CMND/Căn cước:</label><br>
                    <input type='number' id="icNumber" name="icNumber" value="<?php echo $variables->getIcNumber(); ?>"><br>
                    <label for="phone">Số điện thoại: </label><br>
                    <input type="number" id="phone" name="phone" value="<?php echo $variables->getPhone(); ?>"><br>
                    <label for="dateOfBirth">Ngày sinh: </label><br>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $variables->getDateOfBirth(); ?>"><br>
                    <label for="address">Địa chỉ: </label><br>
                    <input type="text" id="address" name="address" value="<?php echo $variables->getAddress(); ?>"><br>
                    <?php
                    if (isset($_SESSION["current_user"]) && 
                                   $_SESSION["current_user"] && 
                                   unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE){
                        echo "<label for='type'>Loại tài khoản (0-admin, 1-thủ thư, 2-thành viên): </label><br>"
                                . "<input type='number' id='type' name='type' value='" 
                                . strval($variables->getType()) . "'><br>";
                    }
                    ?>
                    <input class="green-btn" type="submit" value="Lưu">
                </form> 
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>