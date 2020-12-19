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
            <h1 style="color: red">User lists</h1><br
                <h2><a href="/user/add">Thêm User</a><h2> 
      
            <div class="book_list">
                <table style="width: 50%">
                    <tr>
                        <th>ID</th>
                        <th>Name User</th>
                        <th>Email</th>
                        <th>IcNumber</th>
                        <th>Phone</th>
                        <th>Ngay sinh</th>
                        <th>Dia chi</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
            <?php
            foreach ($variables as $user){
                ?>
            <ul>
                    <?php
                        echo "<tr><td>" .$user->getUserId() . "</td>"                                
                                . "<td>" .$user->getName() . "</td>"
                                . "<td>" .$user->getEmail() . "</td>"
                                . "<td>" .$user->getIcNumber() . "</td>"
                                . "<td>" .$user->getPhone() . "</td>"
                                . "<td>" .$user->getDateOfBirth() . "</td>"
                                . "<td>" .$user->getAddress() . "</td>"
                                . "<td>" .$user->getType() . "</td>"
                                . "<td>" .$user->getStatus() . "</td>"                                
                                . "<td><a href='/user/delete?id={$user->getUserId()}'}>Xóa</a></td>"
                                . "<td><a href='/user/update?id={$user->getUserId()}'}>Sửa</a></td><tr>"
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