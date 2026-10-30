<?php
include "conn.php";

if (isset($_POST["return"])) {
    $id = (int) $_POST["id"];
    $qty = (int) $_POST["qty"];

    mysqli_begin_transaction($conn);

    $result = mysqli_query($conn, "SELECT * FROM borrowed WHERE id = $id FOR UPDATE");
    $row = mysqli_fetch_assoc($result);

    if ($row && $qty > 0 && $qty <= $row["quantity"] - $row["returned_quantity"]) {

        $item = $row["item_id"];

        mysqli_query($conn, "UPDATE borrowed SET returned_quantity = returned_quantity + $qty WHERE id = $id");

        mysqli_query($conn, "UPDATE inventory SET quantity = quantity + $qty WHERE id = $item");

        mysqli_commit($conn);
        echo "Item Returned!";
    } else {
        mysqli_rollback($conn);
        echo "Invalid Quantity!";
    }
}

$records = mysqli_query($conn, "SELECT * FROM borrowed");
?>

<h2>Return Item</h2>

<form method="post">
    <label>Borrower:</label>

    <select name="id" required>
        <option value="">Select Borrower</option>

        <?php while ($row = mysqli_fetch_assoc($records)) {
            $left = $row["quantity"] - $row["returned_quantity"];
            if ($left <= 0) continue;
        ?>
            <option value="<?= $row['id'] ?>">
                <?= htmlspecialchars($row['borrower']) ?> -
                Item <?= $row['item_id'] ?> -
                Remaining: <?= $left ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Return Quantity:</label>
    <input type="number" name="qty" min="1" required>
    <br><br>

    <button name="return" value="1">Return Item</button>
</form>