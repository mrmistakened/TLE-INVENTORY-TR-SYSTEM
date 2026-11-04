<?php
include"conn.php"

if(isset($_GET["search"])){
$id = (int) $_GET["search"];
$sql = "SELECT * FROM student WHERE id = $id";

}else{
   $sql = "SELECT * FROM student";
}
$result = mysqli_query($conn $sql, );
?>
