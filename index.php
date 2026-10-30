<?php

include "conn.php";
$sql = "SELECT * FROM inventory";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link rel = stylesheet href = style.css>
    <title>SMIS</title>
</head>
<body>
    <h2>School Management Inventory System</h2>
    <br>
      <a href="add.php">
        <button type="button">Add Item</button>
</a>
<br>
    Search Item: <input name="search"> <button name="search1" value="1">Search</button>
    <br>
    <br>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["itemname"]; ?></td>
            <td><?php echo $row["quantity"]; ?></td>
            <td>
                <a href="edit.php">
              <Button class="edit">Edit</Button>
              </a>
              <a href="delete.php">
              <Button class="delete">Delete</Button>
            </a>
              <a href="borrow.php">
                <button class="borrow">Borrow Item</button>
            </a>
            </td>
        </tr>

        <?php } ?>

          


    </table>
    <a href="index.php">
        <button type="logout">Log Out</button>
</a>
</body>
</head>
</html>
