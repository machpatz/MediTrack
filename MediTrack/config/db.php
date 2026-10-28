<?php
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP default is empty
$database = "meditrack_db";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
