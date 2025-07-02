<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "food_chain";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$date = $_GET['date'] ?? '';
$time = $_GET['time'] ?? '';
$ambiance = $_GET['ambiance'] ?? '';

if (!$date || !$time || !$ambiance) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$stmt = $conn->prepare("SELECT table_id FROM bookings WHERE date = ? AND time = ? AND ambiance = ?");
$stmt->bind_param("sss", $date, $time, $ambiance);
$stmt->execute();
$result = $stmt->get_result();

$booked_tables = [];
while ($row = $result->fetch_assoc()) {
    $booked_tables[] = (int)$row['table_id'];
}

$stmt->close();
$conn->close();

echo json_encode(['booked_tables' => $booked_tables]);
?>