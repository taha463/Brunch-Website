<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode([]);
    exit;
}

// Get email from session
$email = $_SESSION['user'];

$host = "localhost";
$username = "root";
$password = "";
$dbname = "food_chain";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

// Fetch reservations for this user
$stmt = $conn->prepare("SELECT id, table_id, date, time FROM bookings WHERE email = ?");
$stmt->bind_param("s", $email);

$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = [
        'id' => $row['id'],
        'table_id' => $row['table_id'],
        'date' => $row['date'],
        'time' => $row['time']
    ];
}

echo json_encode($reservations);

$stmt->close();
$conn->close();
?>