<?php
// Include the database configuration file
include 'db_config.php';

// Get user input from form
$name = $_POST['name'];
$email = $_POST['email'];

// Insert the data into the database
$sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Record saved successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
