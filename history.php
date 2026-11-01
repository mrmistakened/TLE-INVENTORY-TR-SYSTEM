<?php
include "../conn.php";

$sql = "SELECT * FROM borrow";

$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="style.css">

<h2>Borrowing Status</h2>

<table>
    <tr>
        <th>Item ID</th>
        <th>Borrower</th>
        <th>Borrow Date</th>
        <th>Return Date</th>
        <th>Status</th>
        <th>Returned Quantity</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) {

        $quantity = $row["quantity"];
        $returned = $row["returned_quantity"];

        if ($returned >= $quantity) {
            $status = "Returned";
        } else {
            $status = "Borrowed";
        }
    ?>

    <tr>
        <td><?php echo $row["item_id"]; ?></td>
        <td><?php echo htmlspecialchars($row["borrower"]); ?></td>
        <td><?php echo $row["borrow_date"]; ?></td>
        <td>
            <?php
            echo !empty($row["return_date"])
                ? $row["return_date"]
                : "";
            ?>
        </td>
        <td><?php echo $status; ?></td>
        <td><?php echo $returned; ?></td>
    </tr>

    <?php } ?>
</table>

<br><br>

<a href="/DELATORRE/index.php">
        <button type="button">Back To Dashboard</button>
        </a>
        <a href="/DELATORRE/inventory">
        <button type="button">Back To Inventory</button>
        </a>