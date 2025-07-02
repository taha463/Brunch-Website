<?php
header('Content-Type: application/json');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "food_chain";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$conn->query("CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    guests INT NOT NULL,
    ambiance VARCHAR(20) NOT NULL,
    table_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['full_name'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = (int)$_POST['guests'];
    $ambiance = $_POST['ambiance'];
    $table_id = (int)$_POST['table_id'];

    $errors = [];
    if (!$full_name) $errors[] = "Name required";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";
    if (!$date) $errors[] = "Date required";
    if (!$time) $errors[] = "Time required";
    if (!$guests || $guests < 1 || $guests > 8) $errors[] = "Guest count invalid";
    if (!$ambiance || !in_array($ambiance, ['indoor', 'al-fresco', 'rooftop'])) $errors[] = "Ambiance required";
    if (!$table_id) $errors[] = "Table selection required";

    if (!$errors) {
        $checkStmt = $conn->prepare("SELECT id FROM bookings WHERE table_id = ? AND ambiance = ? AND date = ? AND time = ?");
        $checkStmt->bind_param("isss", $table_id, $ambiance, $date, $time);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $errors[] = "Selected table is already booked at that time.";
        }
        $checkStmt->close();
    }

    if ($errors) {
        echo json_encode(['success' => false, 'error' => implode("; ", $errors)]);
        exit;
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (full_name, email, date, time, guests, ambiance, table_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisi", $full_name, $email, $date, $time, $guests, $ambiance, $table_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => "Database error: " . $stmt->error]);
        }
        $stmt->close();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

$conn->close();
?>