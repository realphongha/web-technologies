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
        require_once __DIR__ . '/../fragments/menu.php';
        ?>
        
        <div id="content">
            <h1>Thêm sách</h1>
            <div class="addBookForm">
                <form action="/book/add" method="post">
                    <label class="form-required" for="title">Tên sách:</label><br>
                    <input type="text" id="title" name="title"><br>
                    <label class="form-required" for="category">Thể loại:</label><br>
                    <input type="text" id="category" name="category"><br>
                    <label class="form-required" for="author">Tác giả:</label><br>
                    <input type="text" id="author" name="author"><br>
                    <label class="form-required" for="language">Ngôn ngữ:</label><br>
                    <input type="text" id="language" name="language"><br>
                    <label for="publisher">Nhà xuất bản:</label><br>
                    <input type="text" id="publisher" name="publisher"><br>
                    <label class="form-required" for="price">Giá:</label><br>
                    <input type="number" id="price" name="price"><br>
                    <label class="form-required" for="amount">Số lượng:</label><br>
                    <input type="number" id="amount" name="amount"><br>
                    <input type="submit" value="Thêm sách">
                </form> 
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>