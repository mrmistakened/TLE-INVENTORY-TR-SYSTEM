<?php
include "conn.php";

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=students.csv");

$file = fopen("php://output", "w");

fputcsv($file, ["ID", "Firstname", "Lastname"]);

$sql = "SELECT * FROM student";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($file, [
        $row["id"],
        $row["firstname"],
        $row["lastname"]
    ]);
}

fclose($file);
?>