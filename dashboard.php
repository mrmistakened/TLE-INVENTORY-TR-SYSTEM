
<h2>Student Dashboard</h2>
 <img src="cnsf3.png" class="logo" alt="Logo">
<link rel="stylesheet" href="dashboard.css">

<?php
session_start();
include "conn.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["student_id"];

$sql = "SELECT * FROM student WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Student not found!");
}
?>


<h3>Welcome,
<?php echo ($row["firstname"]); ?>!
</h3>

<p>Student ID: <?php echo $row["id"]; ?></p>
<p>First Name:
<?php echo ($row["firstname"]); ?>
</p>
<p>Last Name:
<?php echo ($row["lastname"]); ?>
</p>
<p>Age: <?php echo $row["age"]; ?></p>

<a href="login.php">
        <button type="logout">Log Out</button>
        </a>