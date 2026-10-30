 <form method="post">
 
 Product Name:<input name="itemname"> <br>
    Quantity: <input name="quantity"> <br>
    <button name="add" value="1">Add</button>

</form>
    
<?php
include "conn.php";
$itemname = '$_POST["itemname"]';
$Quantity = '$_POST["quantity"]';

if (isset($_POST["add"])) {

    $sql = "INSERT INTO inventory (itemname, quantity) VALUES ('" . $_POST["itemname"] . "' , '" . $_POST["quantity"] . "')";

    mysqli_query($conn, $sql);
    header("Location:/PIEZAS/Inventory/index.php");
    exit();
    
} else {
    echo "Error";
}
?>

<br>
<a href="index.php">
        <button type="logout">Exit</button>
</a>