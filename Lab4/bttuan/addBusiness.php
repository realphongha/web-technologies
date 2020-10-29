<?php
require 'lib.php';
$error = array();
if (isset($_POST['submit'])) {
    # xu ly category
    if (empty($_POST['cat'])) {
        $error['cat'] = "khong duoc de trong";
    } else {
        $list_cat = array();
        foreach ($_POST['cat'] as $item) {
            $list_cat[] = $item;
        }
    }
    #xu ly business name
    if (empty($_POST['bsn_name'])) {
        $error['bsn_name'] = "khong duoc bo trong";
    } else {
        $bsn_name = $_POST['bsn_name'];
    }
    #xu ly address
    if (empty($_POST['bsn_address'])) {
        $error['bsn_address'] = "khong duoc bo trong";
    } else {
        $bsn_address = $_POST['bsn_address'];
    }
    #xu ly city
    if (empty($_POST['bsn_city'])) {
        $error['bsn_city'] = "khong duoc bo trong";
    } else {
        $bsn_city = $_POST['bsn_city'];
    }
    #xu ly telephone
    if (empty($_POST['bsn_phone'])) {
        $error['bsn_phone'] = "khong duoc bo trong";
    } else {
        $bsn_phone = $_POST['bsn_phone'];
    }
    #xu ly url
    if (empty($_POST['bsn_url'])) {
        $error['bsn_url'] = "khong duoc bo trong";
    } else {
        $bsn_url = $_POST['bsn_url'];
    }

    #xu ly submit
    if (empty($error)) {
        $data1 = array(
            'bsn_name' => $bsn_name,
            'bsn_address' => $bsn_address,
            'bsn_city' => $bsn_city,
            'bsn_phone' => $bsn_phone,
            'bsn_url' => $bsn_url
        );
        $id = db_insert("business", $data1);

        foreach ($list_cat as $item) {
            $data2 = array(
                'bsnID' => $bsn_name,
                'catID' => $item
            );
            $id2 = db_insert("bsn_cat", $data2);
        }
        header("location: success.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css.css" />
    <title>Add business</title>
</head>

<body>
    <div style="padding-right: 16px; display:flex; padding-left: 16px">
        <a style="margin-right: auto; font-size: 18px;" href="show.php">Show Business</a>
        <a style="margin-left: auto; font-size: 18px;" href="CategoryAdmin.php">Add Category</a>
    </div>
    <div style="display: flex">
        <h1 style="margin:auto; margin-top: 24px; margin-bottom: 24px">Business Registration</h1>
    </div>
    <form action="" method="POST" class="formbsn">
        <table class="tb_reg">
            <tr>
                <td>
                    <p>Click on one, or control-click on</br> multiple categories</p>
                    <?php
                    $query = "SELECT * FROM category";
                    $list =  db_fetch_array($query);
                    $count = db_num_rows($query);
                    ?>
                    <select name="cat[]" size="<?php echo $count; ?>" multiple>
                        <?php
                        foreach ($list as $item) {
                        ?>
                            <option value="<?php echo $item['catID']; ?>"><?php echo $item['title']; ?></option>
                            </hr>
                        <?php } ?>
                    </select>
                    <?php echo form_error('cat'); ?>
                </td>
                <td>
                    <table>
                        <tr>
                            <td><label for="bsn_name">Business Name</label></td>
                            <td><input class="bus-input" type="text" name="bsn_name" /><?php echo form_error('bsn_name'); ?></td>
                        </tr>
                        <tr>
                            <td><label for="bsn_address">Address</label></td>
                            <td><input class="bus-input" type="text" name="bsn_address" /><?php echo form_error('bsn_address'); ?></td>
                        </tr>
                        <tr>
                            <td><label for="bsn_city">City</label></td>
                            <td><input class="bus-input" type="text" name="bsn_city" /><?php echo form_error('bsn_city'); ?></td>
                        </tr>
                        <tr>
                            <td><label for="bsn_phone">telephone</label></td>
                            <td><input class="bus-input" type="number" name="bsn_phone" /><?php echo form_error('bsn_phone'); ?></td>
                        </tr>
                        <tr>
                            <td><label for="bsn_url">URL</label></td>
                            <td><input class="bus-input" type="text" name="bsn_url" /><?php echo form_error('bsn_url'); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="hidden" name="add_record" value="1" />
            <input class="bus-submit" type="submit" name="submit" value="Add Business" />
        </p>
    </form>
</body>

</html>