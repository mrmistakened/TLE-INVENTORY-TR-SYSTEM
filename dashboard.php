
<?php
session_start();
include "conn.php";

// CHECK IF STUDENT IS LOGGED IN
if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION["student_id"];

// GET STUDENT INFORMATION
$sql = "SELECT * FROM student WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Student not found!");
}

// GET STUDENT FULL NAME
$student_name = trim($row["firstname"] . " " . $row["lastname"]);

// PAGINATION SETTINGS
$limit = 5;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

if ($page < 1) {
    $page = 1;
}

// GET TOTAL BORROWING RECORDS
$count_sql = "SELECT COUNT(*) AS total
              FROM borrow
              WHERE LOWER(TRIM(borrower)) = LOWER(?)";

$count_stmt = mysqli_prepare($conn, $count_sql);
mysqli_stmt_bind_param($count_stmt, "s", $student_name);
mysqli_stmt_execute($count_stmt);

$count_result = mysqli_stmt_get_result($count_stmt);
$count_row = mysqli_fetch_assoc($count_result);

$total_records = (int)$count_row["total"];

$total_pages = max(1, (int)ceil($total_records / $limit));

// PREVENT INVALID PAGE
if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $limit;

// GET BORROWING SUMMARY
$summary_sql = "SELECT
    COUNT(*) AS total,
    SUM(CASE WHEN status = 'Borrowed' THEN 1 ELSE 0 END) AS borrowed,
    SUM(CASE WHEN status = 'Returned' THEN 1 ELSE 0 END) AS returned
    FROM borrow
    WHERE LOWER(TRIM(borrower)) = LOWER(?)";

$summary_stmt = mysqli_prepare($conn, $summary_sql);
mysqli_stmt_bind_param($summary_stmt, "s", $student_name);
mysqli_stmt_execute($summary_stmt);

$summary_result = mysqli_stmt_get_result($summary_stmt);
$summary = mysqli_fetch_assoc($summary_result);

$total_borrowed = (int)$summary["borrowed"];
$total_returned = (int)$summary["returned"];

// GET PAGINATED BORROWING RECORDS
$borrow_sql = "SELECT * FROM borrow
               WHERE LOWER(TRIM(borrower)) = LOWER(?)
               ORDER BY borrow_date DESC, id DESC
               LIMIT ? OFFSET ?";

$borrow_stmt = mysqli_prepare($conn, $borrow_sql);

mysqli_stmt_bind_param(
    $borrow_stmt,
    "sii",
    $student_name,
    $limit,
    $offset
);

mysqli_stmt_execute($borrow_stmt);

$borrow_result = mysqli_stmt_get_result($borrow_stmt);

$records = [];

while ($borrow = mysqli_fetch_assoc($borrow_result)) {
    $records[] = $borrow;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users Dashboard</title>

    <link rel="stylesheet" href="dashboard.css?v=3">

</head>

<body>

<div class="dashboard">

    <!-- SCHOOL LOGO -->

    <img src="cnsf3.png" class="logo" alt="School Logo">

    <h2>Users Dashboard</h2>

    <h3>
        Welcome,
        <?php echo htmlspecialchars($row["firstname"]); ?>!
    </h3>

    <!-- USER INFORMATION -->

    <h3>Users Information</h3>

    <p>
        <strong>Users ID:</strong>
        <?php echo htmlspecialchars($row["id"]); ?>
    </p>

    <p>
        <strong>First Name:</strong>
        <?php echo htmlspecialchars($row["firstname"]); ?>
    </p>

    <p>
        <strong>Last Name:</strong>
        <?php echo htmlspecialchars($row["lastname"]); ?>
    </p>

    <!-- BORROWING SUMMARY -->

    <h3>Users Borrowing Summary</h3>

    <div class="summary-container">

        <div class="summary-card">
            <h2><?php echo $total_records; ?></h2>
            <p>Total Records</p>
        </div>

        <div class="summary-card">
            <h2><?php echo $total_borrowed; ?></h2>
            <p>Not Returned</p>
        </div>

        <div class="summary-card">
            <h2><?php echo $total_returned; ?></h2>
            <p>Returned</p>
        </div>

    </div>

    <!-- BORROWING HISTORY -->

    <h3>Borrowing and Returning History</h3>

    <?php if (count($records) > 0): ?>

        <div class="table-container">

            <table class="borrow-table">

                <thead>
                    <tr>
                        <th>Borrow ID</th>
                        <th>Item ID</th>
                        <th>Quantity</th>
                        <th>Borrowed Quantity</th>
                        <th>Returned Quantity</th>
                        <th>Borrowed Date</th>
                        <th>Returned Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($records as $borrow): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($borrow["id"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($borrow["item_id"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($borrow["quantity"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($borrow["borrowed_quantity"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($borrow["returned_quantity"]); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($borrow["borrow_date"]); ?>
                            </td>

                            <td>
                                <?php
                                echo !empty($borrow["return_date"])
                                    ? htmlspecialchars($borrow["return_date"])
                                    : "Not yet returned";
                                ?>
                            </td>

                            <td>

                                <?php if ($borrow["status"] == "Returned"): ?>

                                    <span class="returned">
                                        Returned
                                    </span>

                                <?php else: ?>

                                    <span class="borrowed">
                                        Not Returned
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->

        <div class="pagination">

            <a href="?page=<?php echo max(1, $page - 1); ?>"
               class="<?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                &laquo; Previous
            </a>

            <span>
                Page <?php echo $page; ?> of <?php echo $total_pages; ?>
            </span>

            <a href="?page=<?php echo min($total_pages, $page + 1); ?>"
               class="<?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                Next &raquo;
            </a>

        </div>

        <p class="page-info">

            Showing <?php echo $offset + 1; ?> -
            <?php echo $offset + count($records); ?>

            of <?php echo $total_records; ?> records

        </p>

    <?php else: ?>

        <p class="no-record">
            You don't have any borrowing records yet.
        </p>

    <?php endif; ?>

    <!-- LOGOUT -->

    <form action="logout.php" method="POST">

        <button type="submit" class="logout-btn">
            Log Out
        </button>

    </form>

</div>

</body>
</html>

