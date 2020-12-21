<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Đổi mật khẩu</title>
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
            <h1>Đổi mật khẩu</h1>
            <div class="addBookForm">
                <form class="fill-form" 
                      action="/auth/changePassword" method="post">
                    <label class="form-required" for="oldPassword">Mật khẩu cũ:</label><br>
                    <input type="password" id="oldPassword" name="oldPassword"><br>
                    <label class="form-required" for="newPassword">Mật khẩu mới:</label><br>
                    <input type="password" id="newPassword" name="newPassword"><br>
                    <label class="form-required" for="confirmPassword">Nhập lại mật khẩu mới:</label><br>
                    <input type="password" id="confirmPassword" name="confirmPassword"><br>
                    <input class="green-btn" type="submit" value="Đổi mật khẩu">
                </form>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>