<?php
$servername = "localhost";
$username = "csgo";
$password = "BLZV2aVmV6DK4ctm";
$dbname = "csgo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE TABLE Tests (id INT(6) PRIMARY KEY)";
if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

