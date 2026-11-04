

<?php
include "conn.php";

if (isset($_GET["search"])) {

    $id = (int) $_GET["search"];
    $sql = "SELECT * FROM student WHERE id = $id";

} else {

    $sql = "SELECT * FROM student";

}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
</head>
<body>

    <h2>Student Management System</h2>

    <a href="add.php">
        <button type="button">Add Student</button>
    </a>

    <h3>Search Student</h3>

    <form action="index.php" method="get">
        Student ID:
        <input type="number" name="search" min="1" required>
        <button type="submit">Search</button>
        <a href="index.php">Show All</a>
    </form>

    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <tr>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo htmlspecialchars($row["firstname"]); ?></td>
            <td><?php echo htmlspecialchars($row["lastname"]); ?></td>
            <td><?php echo $row["age"]; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">
                    <button type="button" class="edit">Edit</button>
                </a>

                <form action="delete.php" method="post"
                      onsubmit="return confirm('Are you sure you want to delete?');"
                      style="display:inline;">

                    <input type="hidden" name="id"
                           value="<?php echo $row['id']; ?>">

                    <button type="submit" name="delete" class="delete">
                        Delete
                    </button>
                </form>
            </td>
        </tr>

        <?php } ?>

    </table>
    <a href="/DELATORRE/inventory">
        <button type="logout">Go to Inventory</button>
        </a>

        <a href="/DELATORRE/login.php">
        <button type="button">Log Out</button>
        </a>
</body>
</html>
