<?php
require 'lib.php';

$error = array();
if (isset($_POST['btn_post'])) {

    #xu ly catID
    if (empty($_POST['catID'])) {
        $error['catID'] = "Khong duoc bo trong";
    } else {
        $catID = $_POST['catID'];
    }
    # xu ly title
    if (empty($_POST['title'])) {
        $error['title'] = "Khong duoc bo trong";
    } else {
        $title = $_POST['title'];
    }
    #xu ly description
    if (empty($_POST['description'])) {
        $error['description'] = "Khong duoc bo trong";
    } else {
        $description = $_POST['description'];
    }


    if (empty($error)) {
        $data = array(
            'catID' => $catID,
            'title' => $title,
            'description' => $description
        );
        $id = db_insert("category", $data);
        unset($_POST);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css.css" />
    <title>category</title>
</head>

<body>
    <div style="padding-right: 16px; display:flex">
        <a style="margin-left: auto; font-size: 18px;" href="addBusiness.php">Add business</a>
    </div>
    <div style="display: flex; margin-top: 24px; margin-bottom: 24px">
        <h1 style="margin: auto">Category Administrasion</h1>
    </div>
    <table class="table">
        <tr>
            <th>CatID</th>
            <th>Title</th>
            <th>Description</th>
        </tr>
        <?php
        $query = "SELECT * FROM category";
        $list =  db_fetch_array($query);
        foreach ($list as $item) {
        ?>
            <tr>
                <td><?php echo $item['catID']; ?></td>
                <td><?php echo $item['title']; ?></td>
                <td><?php echo $item['description']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <form action="" method="POST">
                <td><input class="cat-input" type="text" name="catID" placeholder="CatID"></input><?php echo form_error('catID'); ?></td>
                <td><input class="cat-input" type="text" name="title" placeholder="Title"></input><?php echo form_error('title'); ?></td>
                <td><input class="cat-input" type="text" name="description" placeholder="Description"></input><?php echo form_error('description'); ?></td>
        </tr>
        <tr>
            <td>
                <input class="cat-submit" type="submit" name="btn_post" value="Add Category" /></td>
            </form>
        </tr>
    </table>
</body>

</html>