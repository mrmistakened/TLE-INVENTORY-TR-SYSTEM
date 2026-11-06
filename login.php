<?php
session_start();
include "conn.php";

$message = "";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM student
            WHERE username = ? AND password = ?";

    $result = mysqli_execute_query($conn, $sql, [$username, $password]);

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        session_regenerate_id(true);

        $_SESSION["student_id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];

        if ($row["role"] == "admin") {
            header("Location: index.php");
            exit();
        } else {
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<form method="post">
            <img src="cnsf3.png" class="logo" alt="Logo">

    <h2>LOGIN FORM</h2>

    Username:
    <input type="text" name="username" required>

    <br><br>

    Password:
    <input type="password" name="password" required>

    <br><br>

    <button type="submit" name="login" value="1">
        Login
    </button>

    <br><br>

    <?php echo $message; ?>
</form>

</body>
</html>
