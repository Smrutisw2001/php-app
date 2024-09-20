<?php
// Database configuration
$servername = "mysqldb.c70ikgow8mn5.ap-south-1.rds.amazonaws.com";  // Replace with your RDS endpoint
$username = "admin";     // Your DB username
$password = "Kanhu2001";     // Your DB password
$dbname = "mysqldb";              // Your DB name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
