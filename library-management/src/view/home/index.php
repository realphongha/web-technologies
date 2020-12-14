<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Trang chủ</title>
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
            <h2>Top 5 books</h2>
            <?php
            foreach ($variables as $book){
                ?>
                <h3>
                    <?php
                        echo "<a href='/book/view?id={$book->getBookId()}'>"
                                . $book->getTitle() . "</a>: " 
                                . $book->getPrice() . " (VND)";
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
