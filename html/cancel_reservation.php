<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "food_chain";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$reservationId = (int)($data['id'] ?? 0);

if (!$reservationId) {
    echo json_encode(['success' => false, 'message' => 'Invalid reservation ID']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $reservationId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No reservation found with that ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error canceling reservation']);
}

$stmt->close();
$conn->close();
?>