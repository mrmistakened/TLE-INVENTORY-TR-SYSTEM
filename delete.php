<form method="post">
  ITEM ID: <input type="number" name="id" required>
  <button name="delete" value="1">Delete</button>
</form>
<?php
if (isset($_POST["delete"])) {
  $conn = mysqli_connect("localhost", "root", "", "login");
  $id = intval($_POST["id"]);
  $sql = "DELETE FROM inventory WHERE id = " . $id;
  mysqli_query($conn, $sql);
   header("Location:/PIEZAS/Inventory/index.php");
   exit();
}
?>
