<?php
// db.php - Database connection file
$servername = "localhost"; // Change to your actual host if not localhost
$username = "uannmukxu07nw";
$password = "nhh1divf0d2c";
$dbname = "dbdv525eoogk96";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
