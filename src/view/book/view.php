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
        require_once __DIR__ . '/../fragments/banner.php';        
        require_once __DIR__ . '/../fragments/menu.php';       
        ?>
        
        <div id="content" style="text-align: center">
            <h1>Thông tin sách</h1>
            <div id="bookDetails" class="item-card">
                <img src="<?php echo $variables->getImage(); ?>"/><br>
                <?php 
                echo "<h1>" , $variables->getTitle(), "</h1>";
                echo "<p class='price'>" , $variables->getPrice(), " VND</p>";
                echo "Thể loại: <b>" , $variables->getCategory(), "</b></br>";
                echo "Tác giả: <b>" , $variables->getAuthor(), "</b></br>";
                echo "Ngôn ngữ: <b>" , $variables->getLanguage(), "</b></br>";
                echo "Nhà xuất bản: <b>" , $variables->getPublisher(), "</b></br>";
                echo "Số lượng còn lại: <b>" , $variables->getAmount(), "</b></br>";
                ?>
                <br>
                <a href="<?php echo '/borrowBook/rent?bookId=' . $variables->getBookId(); ?>"><button>Mượn</button></a>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>