<?php 
include "conn.php";
if(isset($_POST["delete"])){
    $id = (int) $_POST["id"];
    $sql = "DELETE FROM student WHERE id = $id";
    mysqli_query($conn, $sql);
    header ("Location: index.php");
    exit;
}
?>