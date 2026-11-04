<?php
include "conn.php";
$id = (int) $_GET["id"];
$sql = "SELECT * FROM student WHERE id = $id";  
$result = mysqli_query($conn, $sql); 
$row=mysqli_fetch_assoc($result);

if (isset($_POST["edit"])) {
$firstname = $_POST["firstname"]; $lastname = $_POST["lastname"]; $age = $_POST["age"];
  $sql = "UPDATE student SET firstname='$firstname', lastname='$lastname', age='$age' WHERE id = $id";
  mysqli_query($conn, $sql);
  header("Location: index.php");
  exit;
}
?>
<form method="post">
<link rel="stylesheet" href="ae.css">
 firstname: <input type="text" name="firstname" value="<?php echo ($row['firstname']);?>" required>
  lastname: <input type="text" name="lastname" value="<?php echo ($row['lastname']);?>" required>
  age: <input type="text" name="age" value="<?php echo ($row['age']);?>" required>
  <button name="edit" value="1">Edit</button>
</form>
