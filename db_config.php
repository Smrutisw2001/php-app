<?php
// Database configuration
$servername = "your rds server endpoint";  // Replace with your RDS endpoint
$username = "user name";     // Your DB username
$password = "passwd";     // Your DB password
$dbname = "database name";              // Your DB name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
