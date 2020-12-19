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
        require_once __DIR__ . '/../fragments/banner.php';        
        require_once __DIR__ . '/../fragments/menu.php';       
        ?>
        
        <div id="content">
            <h1>Update user</h1>
            <div id="updateUserForm">
                <form action="<?php echo "/user/update?id=" . strval($variables->getUserId()); ?>" 
                      method="post" enctype="multipart/form-data">
                    <label for="email">Email: </label><br>
                    <input type="text" id="email" name="email" value="<?php echo $variables->getEmail(); ?>"><br>
                    <label for="password">Password: </label><br>
                    <input type="text" id="password" name="password" value="<?php echo $variables->getPassword(); ?>"><br>
                    <label for="name">Name: </label><br>
                    <input type="text" id="name" name="name" value="<?php echo $variables->getName(); ?>"><br>
                    <label for="icNumber">IcNumber:</label><br>
                    <input type='number' id="icNumber" name="icNumber" value="<?php echo $variables->getIcNumber(); ?>"><br>
                    <label for="phone">Phone: </label><br>
                    <input type="number" id="phone" name="phone" value="<?php echo $variables->getPhone(); ?>"><br>
                    <label for="dateOfBirth">Ngay sinh: </label><br>
                    <input type="date" id="dateOfBirth" name="dateOfBirth" value="<?php echo $variables->getDateOfBirth(); ?>"><br>
                    <label for="address">Địa chỉ: </label><br>
                    <input type="text" id="address" name="address" value="<?php echo $variables->getAddress(); ?>"><br>
                    <label for="type">Type: </label><br>
                    <input type="number" id="type" name="type" value="<?php echo $variables->getType(); ?>"><br>
                    <label class="form-required" for="image">Avt:</label><br>
                    <input type="file" name="image"><br><br>
                    <input type="submit" value="Lưu">
                </form> 
            </div>
        </div>
        
        <?php
        require_once __DIR__ . '/../fragments/footer.php';
        ?>
    </body>
</html>