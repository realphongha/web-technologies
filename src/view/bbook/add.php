<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Thêm giao dịch mượn sách</title>
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
            <h1>Thêm giao dịch mượn sách</h1>
            <div class="addBBookForm">
                <form class="fill-form" action="/bbook/add" method="post" 
                      enctype="multipart/form-data">
                    <label class="form-required" for="bookId">ID sách:</label><br>
                    <input type="number" id="bookId" name="bookId"><br>
                    <label class="form-required" for="userId">ID người mượn:</label><br>
                    <input type="number" id="userId" name="userId"><br>
                    <label class="form-required" for="quantity">Số lượng:</label><br>
                    <input type="number" id="quantity" name="quantity"><br>
                    <label class="form-required" for="fee">Tiền mượn:</label><br>
                    <input type="number" id="fee" name="fee"><br>
                    <input class="green-btn" type="submit" value="Thêm giao dịch mượn sách">
                </form>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>