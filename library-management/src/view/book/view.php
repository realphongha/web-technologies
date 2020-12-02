<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Thông tin sách</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../css/style.css" 
              media="screen" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <?php
        require_once __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../fragments/menu.php';
        ?>
        
        <div id="content">
            <h1>Thông tin sách</h1>
            <div id="bookDetails">
                <?php 
                echo "Tên sách: " , $variables->getTitle(), "</br>";
                echo "Thể loại: " , $variables->getCategory(), "</br>";
                echo "Tác giả: " , $variables->getAuthor(), "</br>";
                echo "Ngôn ngữ: " , $variables->getLanguage(), "</br>";
                echo "Nhà xuất bản: " , $variables->getPublisher(), "</br>";
                echo "Giá: " , $variables->getPrice(), "</br>";
                echo "Số lượng còn lại: " , $variables->getAmount(), "</br>";
                if (isset($_SESSION["current_user"]) && 
                        $_SESSION["current_user"] && 
                        (unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE || 
                                unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE)){
                    echo "Thời gian tạo: " , $variables->getInsertDate(), "</br>";
                    echo "ID người tạo: " , $variables->getInsertBy(), "</br>";
                    echo "Thời gian cập nhật cuối: " , $variables->getUpdateDate(), "</br>";
                    echo "ID người cập nhật cuối: " , $variables->getUpdateBy(), "</br>";
                }
                ?>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>