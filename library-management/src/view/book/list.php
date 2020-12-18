<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Quản lý sách</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="../css/style.css" media="screen" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <?php
        require_once __DIR__ . '/../fragments/header.php';
        require_once __DIR__ . '/../fragments/banner.php';
        if (isset($_SESSION["current_user"]) && $_SESSION["current_user"]){
            require_once __DIR__ . '/../fragments/menu.php';
        }
        ?>
        
        <div id="content">
            <h1 style="color: red">Book lists</h1><br
      
            <div class="book_list">
                <table style="width: 50%">
                    <tr>
                        <th>Ten Sach</th>
                        <th>Gia</th>
                    </tr>
            <?php
            foreach ($variables as $book){
                ?>
            <ul>
                    <?php
                        echo "<tr><td><a href='/book/view?id={$book->getBookId()}'>"
                                . $book->getTitle() . "</a></td>"                                
                                . "<td>" .$book->getPrice() . " (VND)</td>"
                                . "<td><a href='/book/delete?id={$book->getBookId()}'}>Xóa</a></td>"
                                . "<td><a href='/book/update?id={$book->getBookId()}'}>Sửa</a></td></tr>";
                    ?>
            </ul>
                <?php
            }
            ?>
                </table>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>