<?php

$conn = mysqli_connect ("localhost", "root", "", "login");

if (!$conn) {
    die("Connection Failed! What the heck bruh, ts ur error: " . mysqli_connect_error());
}

?>