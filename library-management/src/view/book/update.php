<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Template page. Copy and edit this page.</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../css/style.css" media="screen" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <?php
        require_once __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../fragments/menu.php';
        ?>
        
        <div id="content">
            <h1>Sửa sách</h1>
            <div id="updateBookForm">
                <form action="<?php echo "/book/update?id=" . strval($variables->getBookId()); ?>" 
                      method="post" enctype="multipart/form-data">
                    <label for="title">Tên sách:</label><br>
                    <input type="text" id="title" name="title" value="<?php echo $variables->getTitle(); ?>"><br>
                    <label for="category">Thể loại:</label><br>
                    <input type="text" id="category" name="category" value="<?php echo $variables->getCategory(); ?>"><br>
                    <label for="author">Tác giả:</label><br>
                    <input type="text" id="author" name="author" value="<?php echo $variables->getAuthor(); ?>"><br>
                    <label for="language">Ngôn ngữ:</label><br>
                    <input type="text" id="language" name="language" value="<?php echo $variables->getLanguage(); ?>"><br>
                    <label for="publisher">Nhà xuất bản:</label><br>
                    <input type="text" id="publisher" name="publisher" value="<?php echo $variables->getPublisher(); ?>"><br>
                    <label for="price">Giá:</label><br>
                    <input type="number" id="price" name="price" value="<?php echo $variables->getPrice(); ?>"><br>
                    <label for="fee">Giá mượn:</label><br>
                    <input type="number" id="fee" name="fee" value="<?php echo $variables->getFee(); ?>"><br>
                    <label for="amount">Số lượng:</label><br>
                    <input type="number" id="amount" name="amount" value="<?php echo $variables->getAmount(); ?>"><br>
                    <label class="form-required" for="image">Ảnh sách:</label><br>
                    <input type="file" name="image"><br>
                    <input type="submit" value="Lưu">
                </form> 
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>