<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Access Denied</title>
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
            <h1>Bạn không có quyền truy cập trang này!</h1>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>
