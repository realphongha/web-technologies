<?php
require 'lib.php';
$query1 = "SELECT * FROM category";
$listCat = db_fetch_array($query1);
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query2 = "SELECT * FROM business, bsn_cat WHERE bsn_name=bsnID AND catID='$id'";
    $listBsn = db_fetch_array($query2);
} else {
    $query3 = "SELECT * FROM business";
    $listBsn = db_fetch_array($query3);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css.css" />
    <title>Show</title>
</head>

<body>
    <div style="padding-right: 16px; display:flex">
        <a style="margin-left: auto; font-size: 18px;" href="addBusiness.php">Add business</a>
    </div>
    <h1>Business Listings</h1>
    <table border=0>
        <tr>
            <td>
                <table border=5 style="min-width: 242px">
                    <tr>
                        <td><strong>Click on a category to find business listings:</strong></td>
                    </tr>
                    <?php
                    foreach ($listCat as $item) {
                        echo "<tr><td><a href='show.php?id={$item['catID']}'>{$item['title']}</a></td></tr>";
                    }
                    ?>
                </table>
            </td>
            <td style="width: 74%">
                <table border=1 style="width: 100%">
                    <tr>
                        <th>Business name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>telephone</th>
                        <th>URL</th>
                    </tr>
                    <?php foreach ($listBsn as $item) { ?>
                        <tr>
                            <td><?php echo $item['bsn_name']; ?></td>
                            <td><?php echo $item['bsn_address']; ?></td>
                            <td><?php echo $item['bsn_city']; ?></td>
                            <td><?php echo $item['bsn_phone']; ?></td>
                            <td><?php echo $item['bsn_url']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>