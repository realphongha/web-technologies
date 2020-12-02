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
            <h1>Book lists</h1>
            <a href="/book/add">Thêm sách</a>
            </br>
            <?php
            foreach ($variables as $book){
                ?>
                <h3>
                    <?php
                        echo "<a href='/book/view?id={$book->getBookId()}'>"
                                . $book->getTitle() . "</a>: " 
                                . $book->getPrice() . " (VND)"
                                . "|<a href='/book/delete?id={$book->getBookId()}'}>Xóa</a>"
                                . "|<a href='/book/update?id={$book->getBookId()}'}>Sửa</a>";
                    ?>
                </h3>
                <?php
            }
            ?>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>