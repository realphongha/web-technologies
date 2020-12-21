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
        require_once __DIR__ . '/../fragments/menu.php';       
        ?>
        
        <div id="content">
            <?php
            if (isset($_SESSION["current_user"]) && 
                                   $_SESSION["current_user"] && 
                                   (unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE || 
                                   unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE)){
                ?>
                <a href="/book/add">
                    <input class="green-btn" type="button" value="Thêm sách">
                </a>
            <?php
            }
            ?>
            <h1>DANH SÁCH SÁCH</h1>
            
            <form class="search-form" action="/book/list">
                <input type="text" name="keyword" placeholder="Nhập tên sách, thể loại, tác giả, nhà xuất bản để tìm kiếm...">
            </form>
      
            <div>
                <table class="datatable">
                    <tr>
                        <th>Tên sách</th>
                        <th>Thể loại</th>
                        <th>Tác giả</th>
                        <th>Ngôn ngữ</th>
                        <th>Nhà xuất bản</th>
                        <th>Giá bán</th>
                        <th>Giá mượn</th>
                        <th>Số lượng tồn kho</th>
                        <?php
                        echo isset($_SESSION["current_user"]) && 
                                   $_SESSION["current_user"] && 
                                   (unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE || 
                                   unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE) ?
                        "<th>Xóa</th><th>Sửa</th>" : "";
                        ?>
                    </tr>
                <?php
                foreach ($variables[0] as $book){
                    ?>
                <ul>
                        <?php
                            echo "<tr><td><a href='/book/view?id={$book->getBookId()}'>"
                                    . $book->getTitle() . "</a></td>"        
                                    . "<td>" .$book->getCategory() . "</td>"
                                    . "<td>" .$book->getAuthor() . "</td>"
                                    . "<td>" .$book->getLanguage() . "</td>"
                                    . "<td>" .$book->getPublisher() . "</td>"
                                    . "<td>" .$book->getPrice() . " (VND)</td>"
                                    . "<td>" .$book->getFee() . " (VND)</td>"
                                    . "<td>" .$book->getAmount() . "</td>"
                                    . (isset($_SESSION["current_user"]) && 
                                       $_SESSION["current_user"] && 
                                       (unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE || 
                                       unserialize($_SESSION["current_user"])->getType() == EMPLOYEE_ROLE) ? 
                                            "<td><a href='/book/delete?id={$book->getBookId()}'}>Xóa</a></td>"
                                            . "<td><a href='/book/update?id={$book->getBookId()}'}>Sửa</a></td></tr>" : "");
                        ?>
                </ul>
                    <?php
                }
                ?>
                </table>
                <div class="pagination">
                    <?php
                    $start = ($variables[1]->getCurrentPage()-1)*$variables[1]->getPageSize()+1;
                    $end = $start + $variables[1]->getCurrentPageSize() - 1;
                    if ($variables[1]->getCurrentPage() > 1){
                        echo "<a href='/book/list?page=" 
                            . strval($variables[1]->getCurrentPage()-1) 
                            . "&pageSize="
                            . strval($variables[1]->getPageSize())
                            . ($variables[1]->getKeyword() == ""?"":"&keyword=".$variables[1]->getKeyword())
                            . "'>" . "❮" . "</a>";
                    } else {
                        echo "<a class='is-disabled'>❮</a>";
                    }
                    if ($variables[1]->getCurrentPageSize() > 0){
                        echo "<a class='pg-text'>Hiển thị {$start}-{$end} trong tổng số {$variables[1]->getTotalRecords()} bản ghi</a>";
                    } else {
                        echo "<a class='pg-text'>Không có bản ghi nào phù hợp</a>";
                    }
                    if ($variables[1]->getCurrentPage() < $variables[1]->getTotalPages()){
                        echo "<a href='/book/list?page=" 
                            . strval($variables[1]->getCurrentPage()+1) 
                            . "&pageSize="
                            . strval($variables[1]->getPageSize())
                            . ($variables[1]->getKeyword() == ""?"":"&keyword=".$variables[1]->getKeyword())
                            . "'>". "❯" . "</a>";
                    } else {
                        echo "<a class='is-disabled'>❯</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>