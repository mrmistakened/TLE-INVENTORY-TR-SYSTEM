<form method="post">
  ID: <input name="id" required>
  New Quantity: <input name="quantity" required>
  <button name="edit" value="1">Edit</button>
</form>
<?php

if (isset($_POST["edit"])) {
  $conn = mysqli_connect("localhost", "root", "", "login");
  $id = intval($_POST["id"]);
  $sql = "UPDATE inventory SET quantity = '" . $_POST["quantity"] . "' WHERE id = " . $id;
  mysqli_query($conn, $sql);
  header("Location:/PIEZAS/Inventory/index.php");
  exit();
}
?>
