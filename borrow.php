<?php
include "conn.php";
$message = "";

if (isset($_POST["borrow"])) {
    $id = (int) $_POST["id"];
    $item_id = (int)
    $_POST["item_id"];
    $quantity = (int)
    $date = date("Y-m-d");

    $student = mysqli_query($conn, "SELECT * FROM regis WHERE id = $id");
    $student = mysqli_fetch_assoc($student);

    $item = mysqli_query($conn, "SELECT * FROM inventory WHERE id = $item_id");
    $item = mysqli_fetch_assoc($item);

    if ($student && $item && $quantity > 0 && $item["quantity"] >= $quantity) {
        
        $borrower = $student["Username"] . "" . $student["Gmail"];

            mysqli_begin_transaction($conn);
                try {
                    $sql = "UPDATE inventory SET quantity - $quantity WHERE id = $item_id AND quantity >= $quantity";

                    mysqli_query($conn, $sql);
                    if (mysqli_affected_rows($conn) != 1) {
                        throw new Exception("Not Enough Stock");
                    }
                $sql = "INSERT INTO borrowed (item_id, borrow, quantity, borrow_date, status) VALUES (?,?,?,?,'Borrowed')";

                mysqli_execute_query($conn, $sql, [$item_id, $borrower, $quantity, $date]);

                mysqli_commit($conn);
                    header("Location: index.php");
                    exit;
                } catch (Exception $e) {
                    mysqli_rollback($conn);
                        $message = "Unable to borrow item.";
                } 

    } else {
        $message = "Invalid student, item, or quantity!";
    }
}

$students = mysqli_query($conn, "SELECT * FROM regis");
$items = mysqli_query($conn, "SELECT * FROM inventory");
?>

<h2>Borrow Item</h2>

<p><?php echo $message; ?></p>

<form method="post">

    Student:
    <select name="id" required>
        <option value="">Select Student</option>
        <?php while ($row = mysqli_fetch_assoc($students)) { ?>
            <option value="<?php echo $row["id"]; ?>">
                <?php echo ($row["Username"]); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    Item:
    <select name="item_id" required>
        <option value="">Select Item</option>
        <?php while ($row = mysqli_fetch_assoc($items)) { ?>
            <option value="<?php echo $row["id"]; ?>">
                <?php echo ($row["itemname"]); ?>
                (<?php echo $row["quantity"]; ?> available)
            </option>
        <?php } ?>
    </select>

    <br><br>

    Quantity:
    <input type="number" name="quantity" min="1" required>

    <br><br>

    <button type="submit" name="borrow">Borrow</button>
</form>

<br>
<a href="index.php">Back</a>