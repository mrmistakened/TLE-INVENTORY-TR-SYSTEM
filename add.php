<h3> Users</h3>
<link rel="stylesheet" href="ae.css">
<form method="post">
  Firstname: <input name="firstname" required>
<br>
  lastname: <input name="lastname" required>
<br>
  Username: <input name="username" required>
<br>
  Password: <input name="password" required>
<br>
  <button name="add" value="1">Add Users</button>
  <br>

</form>
 
<?php
if (isset($_POST["add"])) {
  $conn = mysqli_connect("localhost", "root", "", "school_db");
  $sql = "INSERT INTO student (firstname, lastname, age , username , password ) VALUES ('" . $_POST["firstname"] . "', '"  . $_POST["lastname"] . "', '" . $_POST["age"]. "','" . $_POST["username"] . "','" . $_POST["password"] . "')";
  mysqli_query($conn, $sql);
  header("Location: index.php");
  exit;
}
?>