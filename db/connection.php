<?php
$host = 'localhost';        // Database host (usually localhost)
$dbname = 'food_chain';     // Your database name
$username = 'root';         // Your MySQL username (default for XAMPP is root)
$password = '';             // Your MySQL password (empty by default in XAMPP)

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
