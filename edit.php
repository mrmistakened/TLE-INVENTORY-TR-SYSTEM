<?php
include "conn.php";
$id = (int) $_GET["id"];
$sql = "SELECT * FROM inventory WHERE id = $id";  
$result = mysqli_query($conn, $sql); 
$row=mysqli_fetch_assoc($result);

if (isset($_POST["edit"])) {
$id = $_POST["id"]; $item_name = $_POST["item_name"]; $quantity = $_POST["quantity"];
  $sql = "UPDATE inventory SET id='$id', item_name='$item_name', quantity='$quantity' WHERE id = $id";
  mysqli_query($conn, $sql);
  header("Location: index.php");
  exit;
}
?>
<form method="post">
<link rel="stylesheet" href="ae.css">
 ID: <input type="text" name="id" value="<?php echo ($row['id']);?>" required>
  ITEM NAME: <input type="text" name="item_name" value="<?php echo ($row['item_name']);?>" required>
  QUANTITY: <input type="text" name="quantity" value="<?php echo ($row['quantity']);?>" required>
  <button name="edit" value="1">Edit</button>
</form>