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
            <a href="/user/add">
                <input class="green-btn" type="button" value="Thêm tài khoản">
            </a>
            
            <h1>DANH SÁCH TÀI KHOẢN</h1>
                
            <form class="search-form" action="/user/list">
                <input type="text" name="keyword" placeholder="Nhập email, họ tên, số điện thoại để tìm kiếm...">
            </form>    
      
            <div>
                <table class="datatable">
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số CMND/Căn cước</th>
                        <th>Số điện thoại</th>
                        <th>Ngày sinh</th>
                        <th>Địa chỉ</th>
                        <?php
                        echo isset($_SESSION["current_user"]) && 
                                   $_SESSION["current_user"] && 
                                   unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE ?
                        "<th>Loại tài khoản</th>" : "";
                        ?>
                        <th>Xóa</th>
                        <th>Sửa</th>
                    </tr>
            <?php
            foreach ($variables[0] as $user){
                ?>
            <ul>
                    <?php
                        $type = "";
                        switch ($user->getType()){
                            case 0:
                                $type = "Quản trị viên";
                                break;
                            case 1:
                                $type = "Thủ thư";
                                break;
                            case 2:
                                $type = "Thành viên";
                                break;
                            default:
                                break;
                        }
                        echo "<tr><td>" .$user->getUserId() . "</td>"                                
                                . "<td>" .$user->getName() . "</td>"
                                . "<td>" .$user->getEmail() . "</td>"
                                . "<td>" .$user->getIcNumber() . "</td>"
                                . "<td>" .$user->getPhone() . "</td>"
                                . "<td>" .$user->getDateOfBirth() . "</td>"
                                . "<td>" .$user->getAddress() . "</td>"
                                . (isset($_SESSION["current_user"]) && 
                                   $_SESSION["current_user"] && 
                                   unserialize($_SESSION["current_user"])->getType() == ADMIN_ROLE ?
                                "<td>" . $type . "</td>":"" )                            
                                . "<td><a href='/user/delete?id={$user->getUserId()}'}>Xóa</a></td>"
                                . "<td><a href='/user/update?id={$user->getUserId()}'}>Sửa</a></td><tr>"
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
                        echo "<a href='/user/list?page=" 
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
                        echo "<a href='/user/list?page=" 
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