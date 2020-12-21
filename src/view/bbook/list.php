<!DOCTYPE HTML>
<html lang="vi">
    <head>
        <title>Quản lý mượn sách</title>
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
                <a href="/bbook/add">
                    <input class="green-btn" type="button" value="Thêm giao dịch mượn sách">
                </a>
            <?php
            }
            ?>
            <h1>DANH SÁCH GIAO DỊCH MƯỢN SÁCH</h1>
            
            <form class="search-form" action="/bbook/list">
                <input type="text" name="keyword" placeholder="Nhập tên sách hoặc tên người mượn để tìm kiếm...">
            </form>
            <br>
            <?php
            $type = "";
            switch($variables[2]){
                case 0:
                    $type = "Trạng thái: Đã hủy";
                    break;
                case 1:
                    $type = "Trạng thái: Chờ giao dịch";
                    break;
                case 2:
                    $type = "Trạng thái: Đã cho mượn";
                    break;
                case 3:
                    $type = "Trạng thái: Đã trả";
                    break;
                case 4:
                    $type = "Trạng thái: Đã mất/hỏng";
                    break;
                default:
                    $type = "Chọn trạng thái";
                    break;
            }
            ?>
            <div class="dropdown">
                <button class="dropbtn"><?php echo $type; ?></button>
                <div class="dropdown-content">
                    <a href="/bbook/list?status=0">Đã hủy</a>
                    <a href="/bbook/list?status=1">Chờ giao dịch</a>
                    <a href="/bbook/list?status=2">Đã cho mượn</a>
                    <a href="/bbook/list?status=3">Đã trả</a>
                    <a href="/bbook/list?status=4">Đã mất/hỏng</a>
                    <a href="/bbook/list">Tất cả</a>
                </div>
            </div>
      
            <div>
                <table class="datatable">
                    <tr>
                        <th>Tên sách</th>
                        <th>Người mượn</th>
                        <th>Thời gian yêu cầu mượn</th>
                        <th>Thời gian mượn</th>
                        <th>Số lượng mượn</th>
                        <th>Tiền mượn</th>
                        <th>Trạng thái</th>
                    </tr>
                <?php
                foreach ($variables[0] as $bbook){
                    ?>
                <ul>
                        <?php
                            $type = "";
                            switch($bbook->getStatus()){
                                case 0:
                                    $type = "Đã hủy";
                                    break;
                                case 1:
                                    $type = "Chờ giao dịch";
                                    break;
                                case 2:
                                    $type = "Đã cho mượn";
                                    break;
                                case 3:
                                    $type = "Đã trả";
                                    break;
                                case 4:
                                    $type = "Đã mất/hỏng";
                                    break;
                                default:
                                    break;
                            }
                            echo "<tr><td><a href='/book/view?id={$bbook->getBookId()}'>"
                                    . $bbook->getBookName() . "</a></td>"        
                                    . "<td>" .$bbook->getUserName() . "</td>"
                                    . "<td>" .strval($bbook->getTimeRequest()) . "</td>"
                                    . "<td>" .strval($bbook->getTimeBorrow()) . "</td>"
                                    . "<td>" .strval($bbook->getQuantity()) . "</td>"
                                    . "<td>" .strval($bbook->getFee()) . " (VND)</td>";
                            ?>
                            <td class="dropdown">
                                <?php echo $type; ?>
                                <div class="dropdown-content">
                                    <a href="/bbook/change?status=0&id=<?php echo $bbook->getBorrowBookId(); ?>">Đã hủy</a>
                                    <a href="/bbook/change?status=1&id=<?php echo $bbook->getBorrowBookId(); ?>">Chờ giao dịch</a>
                                    <a href="/bbook/change?status=2&id=<?php echo $bbook->getBorrowBookId(); ?>">Đã cho mượn</a>
                                    <a href="/bbook/change?status=3&id=<?php echo $bbook->getBorrowBookId(); ?>">Đã trả</a>
                                    <a href="/bbook/change?status=4&id=<?php echo $bbook->getBorrowBookId(); ?>">Đã mất/hỏng</a>
                                </div>
                            </td>
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