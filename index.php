
<?php
include "conn.php";

if (isset($_GET["search"])) {
    $search = mysqli_real_escape_string($conn, $_GET["search"]);

    $sql = "SELECT * FROM student
            WHERE firstname LIKE '%$search%'
            OR lastname LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM student";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Management System</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    
    <div class="sidebar">

        <h2>TLE MANAGEMENT SYSTEM</h2>

        <a href="index.php" class="active">Users</a>

        <a href="/DELATORRE/inventory">Go to Inventory</a>

        <a href="export.php">Export to Excel</a>

        <a href="/DELATORRE/login.php" class="logout">Log Out</a>

    </div>

    
    <div class="main-content">

        <div class="table-container">

            <h2>Users</h2>

            
            <form action="index.php" method="get">

                Users Name:

                <input type="text"
                    name="search"
                    placeholder="Enter first or last name"
                    required>

                <button type="submit">Search</button>

                <a href="index.php">Show All</a>

                <a href="add.php">Add Student</a>

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

                        <td>
                            <?php echo htmlspecialchars($row["firstname"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row["lastname"]); ?>
                        </td>

                        <td><?php echo $row["age"]; ?></td>

                        <td>

                            <a href="edit.php?id=<?php echo $row['id']; ?>">
                                <button type="button" class="edit">
                                    Edit
                                </button>
                            </a>

                            <form action="delete.php"
                                method="post"
                                onsubmit="return confirm('Are you sure you want to delete?');"
                                style="display:inline;">

                                <input type="hidden"
                                    name="id"
                                    value="<?php echo $row['id']; ?>">

                                <button type="submit"
                                    name="delete"
                                    class="delete">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>
    </div>

</body>
</html>