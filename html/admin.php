<?php
session_start();

// Redirect if not admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: Login.php");
    exit();
}

// DB Connection
$conn = new mysqli("localhost", "root", "", "food_chain");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menu directory and files
$menuDir = '../images';
if (!is_dir($menuDir)) {
    mkdir($menuDir, 0777, true); // Create directory if it doesn't exist
}
$menuFiles = is_dir($menuDir) ? array_diff(scandir($menuDir), ['.', '..']) : [];
$menuCount = count($menuFiles);

// Organize menus by day
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
$menuByDay = [];
foreach ($days as $day) {
    $menuByDay[$day] = null;
    foreach ($menuFiles as $file) {
        if (stripos($file, $day . '_menu') === 0) {
            $menuByDay[$day] = $file;
        }
    }
}

// Initialize counts and data
$today = date("Y-m-d");
$tableCount = 0;
$reservationCount = 0;
$loginCount = 0;
$users = [];
$tableRows = [];
$reservationRows = [];
$bookedTables = [];

// Fetch table data
try {
    if ($conn->query("SHOW TABLES LIKE 'tables'")->num_rows > 0) {
        $tableCount = $conn->query("SELECT COUNT(*) FROM tables")->fetch_row()[0];
        $tableRows = $conn->query("SELECT * FROM tables")->fetch_all(MYSQLI_ASSOC);
    }
    if ($conn->query("SHOW TABLES LIKE 'bookings'")->num_rows > 0) {
        // Count all booked tables (no date filter)
        $reservationCount = $conn->query("SELECT COUNT(*) FROM bookings")->fetch_row()[0];
        $reservationRows = $conn->query("SELECT * FROM bookings")->fetch_all(MYSQLI_ASSOC);
        $bookedTableIds = $conn->query("SELECT DISTINCT table_id FROM bookings")->fetch_all(MYSQLI_ASSOC);
        $bookedTables = array_map('intval', array_column($bookedTableIds, 'table_id'));
        echo "<!-- Debug: Booked Tables = " . implode(', ', $bookedTables) . " -->";
    }
    $result = $conn->query("SELECT * FROM users ORDER BY reg_date DESC");
    if ($result && $result->num_rows > 0) {
        $users = $result->fetch_all(MYSQLI_ASSOC);
    }
    $loginCount = $conn->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
} catch (Exception $e) {
    echo "<!-- Debug: Database Error = " . $e->getMessage() . " -->";
}

// Handle menu upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    $day = $_POST['menu_day'] ?? '';
    $targetDir = "../images/";
    $fileName = basename($_FILES["menu_file"]["name"]);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "webp", "pdf"];
    
    if (!in_array($day, $days)) {
        $uploadError = "Invalid day selected.";
    } elseif (!in_array($fileType, $allowedTypes)) {
        $uploadError = "Only JPG, JPEG, PNG, WEBP, and PDF files are allowed.";
    } else {
        // Construct new filename with day prefix
        $newFileName = $day . '_menu.' . $fileType;
        $targetFile = $targetDir . $newFileName;

        // Delete existing menu for the day, if any
        if ($menuByDay[$day] && file_exists($targetDir . $menuByDay[$day])) {
            unlink($targetDir . $menuByDay[$day]);
        }

        if (move_uploaded_file($_FILES["menu_file"]["tmp_name"], $targetFile)) {
            $uploadSuccess = "The menu for " . ucfirst($day) . " has been uploaded.";
            $menuFiles = array_diff(scandir($menuDir), ['.', '..']);
            $menuByDay[$day] = $newFileName;
            $menuCount = count($menuFiles);
        } else {
            $uploadError = "Upload failed. Error: " . var_export(error_get_last(), true);
        }
    }
}

// Handle menu deletion
if (isset($_GET['delete']) && in_array($_GET['delete'], $days)) {
    $day = $_GET['delete'];
    $fileToDelete = $menuByDay[$day];
    $filePath = $menuDir . '/' . $fileToDelete;
    
    if ($fileToDelete && file_exists($filePath)) {
        if (unlink($filePath)) {
            $deleteSuccess = "Menu for " . ucfirst($day) . " deleted successfully.";
            $menuFiles = array_diff(scandir($menuDir), ['.', '..']);
            $menuByDay[$day] = null;
            $menuCount = count($menuFiles);
        } else {
            $deleteError = "Error deleting menu for " . ucfirst($day) . ".";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="sidebar">
    <div class="brand"><h1>Brunch</h1></div>
    <ul class="nav-links">
        <li><a href="#" class="active" data-target="dashboard"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
        <li><a href="#" data-target="menu"><i class="fas fa-utensils"></i> <span>Menu Management</span></a></li>
        <li><a href="#" data-target="logins"><i class="fas fa-user-clock"></i> <span>Login Activity</span></a></li>
        <li><a href="#" data-target="tables"><i class="fas fa-chair"></i> <span>Table Management</span></a></li>
        <li><a href="#" data-target="reservations"><i class="fas fa-calendar-check"></i> <span>Reservations</span></a></li>
        <li><a href="#" data-target="settings"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <div class="header-title">
            <h1>Admin Dashboard</h1>
            <p>Welcome back, Taha! Today is <?php echo date("l, F j, Y"); ?></p>
        </div>
        <div class="user-info">
            <img src="https://images.pexels.com/photos/1704488/pexels-photo-1704488.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Admin">
            <div>
                <h3>Taha</h3>
                <p>Administrator</p>
            </div>
        </div>
    </div>

    <!-- Dashboard Section -->
    <section id="dashboard" class="content-section active">
        <div class="section-header">
            <h2>Dashboard Overview</h2>
        </div>
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon icon-menu"><i class="fas fa-utensils"></i></div>
                <div class="stat-info">
                    <h3><?php echo $menuCount; ?></h3>
                    <p>Menu Items</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-logins"><i class="fas fa-user-clock"></i></div>
                <div class="stat-info">
                    <h3><?php echo $loginCount; ?></h3>
                    <p> Logins </p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-tables"><i class="fas fa-chair"></i></div>
                <div class="stat-info">
                    <h3><?php echo 36 - $reservationCount; ?></h3> <!-- Total available tables -->
                    <p>Available Tables</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-reservations"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h3><?php echo $reservationCount; ?></h3>
                    <p>Reservations</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Management Section -->
    <section id="menu" class="content-section">
        <div class="section-header">
            <h2>Menu Management</h2>
        </div>
        
        <?php if (isset($uploadSuccess)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $uploadSuccess; ?>
            </div>
        <?php elseif (isset($uploadError)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $uploadError; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($deleteSuccess)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $deleteSuccess; ?>
            </div>
        <?php elseif (isset($deleteError)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $deleteError; ?>
            </div>
        <?php endif; ?>
        
        <div class="filter-buttons">
            <?php foreach ($days as $day): ?>
                <button onclick="showMenu('<?php echo $day; ?>')" <?php echo $day === 'monday' ? 'class="active"' : ''; ?>><?php echo ucfirst($day); ?></button>
            <?php endforeach; ?>
        </div>
        
       <?php foreach ($days as $day): ?>
    <div id="<?php echo $day; ?>-menu" class="menu-card <?php echo $day !== 'monday' ? 'hidden' : ''; ?>">
        <?php if ($menuByDay[$day]): 
            $file = $menuByDay[$day];
            $filePath = $menuDir . '/' . $file;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
            $isPDF = $ext === 'pdf';
            $publicPath = '/FoodChainProject/images/' . $file;
        ?>
            <div class="menu-card-inner">
                <?php if ($isImage): ?>
                    <div class="menu-preview">
                        <img src="<?php echo htmlspecialchars($publicPath); ?>" alt="Menu for <?php echo ucfirst($day); ?>" onload="console.log('Image loaded: ' + this.src);" onerror="console.log('Image failed to load: ' + this.src);">
                    </div>
                <?php elseif ($isPDF): ?>
                    <div class="pdf-preview">
                        <i class="fas fa-file-pdf"></i>
                        <p>PDF Document</p>
                    </div>
                <?php endif; ?>
                <div class="menu-info">
                    <div class="menu-title">
                        <span><?php echo htmlspecialchars($file); ?></span>
                        <span><?php echo strtoupper($ext); ?></span>
                    </div>
                    <div class="menu-actions">
                        <?php if ($isImage): ?>
                            <a href="<?php echo htmlspecialchars($publicPath); ?>" target="_blank" class="menu-action-btn view-btn">
                                <i class="fas fa-eye"></i> View
                            </a>
                        <?php elseif ($isPDF): ?>
                            <a href="<?php echo htmlspecialchars($publicPath); ?>" target="_blank" class="menu-action-btn view-btn">
                                <i class="fas fa-file-download"></i> Download
                            </a>
                        <?php endif; ?>
                        <a href="?delete=<?php echo urlencode($day); ?>" class="menu-action-btn delete-btn" onclick="return confirm('Are you sure you want to delete the menu for <?php echo ucfirst($day); ?>?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-utensils"></i>
                <h3>No Menu for <?php echo ucfirst($day); ?></h3>
                <p>Upload a menu for <?php echo ucfirst($day); ?> to get started.</p>
            </div>
        <?php endif; ?>
        <div class="upload-form">
            <h3>Upload Menu for <?php echo ucfirst($day); ?></h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="file-input-wrapper">
                        <input type="file" name="menu_file" accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                        <input type="hidden" name="menu_day" value="<?php echo $day; ?>">
                    </div>
                    <button type="submit" name="upload" class="upload-btn">
                        <i class="fas fa-upload"></i> Upload Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>
    </section>

    <!-- Login Activity Section -->
    <section id="logins" class="content-section">
        <div class="section-header">
            <h2>Login Activity</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>user</th>
                        <th>reg_date</th>
                        <th>role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($user['user']); ?></td>
                        <td><?php echo htmlspecialchars($user['reg_date']); ?></td>
                        <td><span class="status <?php echo $user['role'] === 'admin' ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars(ucfirst($user['role'])); ?>
                        </span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

  <!-- Table Management Section -->
    <section id="tables" class="content-section">
        <div class="section-header">
            <h2>Table Management</h2>
        </div>
        <div class="table-summary">
            <p>Total Tables: 36 (12 Indoor, 12 Outdoor, 12 Rooftop)</p>
            <p>Booked Tables (Overall): <?php echo $reservationCount; ?></p>
            <p>Remaining Tables: <?php echo 36 - $reservationCount; ?></p>
           
           
        </div>
        <div class="table-responsive">
            
                    <?php foreach ($tableRows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['table_id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['capacity'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['location'] ?? ''); ?></td>
                        <td><span class="status <?php echo in_array($row['table_id'], $bookedTables) ? 'pending' : 'active'; ?>"><?php echo in_array($row['table_id'], $bookedTables) ? 'Booked' : 'Available'; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Reservation Management Section -->
    <section id="reservations" class="content-section">
        <div class="section-header">
            <h2>Reservation Management</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Customer</th>
                        <th>Guests</th>
                        <th>Table</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservationRows as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['time'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['full_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['guests'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['table_id'] ?? ''); ?></td>
                        <td><span class="status <?php 
                            $status = $row['status'] ?? ''; 
                            echo $status === 'Confirmed' ? 'active' : ($status === 'Cancelled' ? 'cancelled' : 'pending'); 
                        ?>"><?php echo htmlspecialchars($status); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Settings Section -->
    <section id="settings" class="content-section">
        <div class="section-header">
            <h2>System Settings</h2>
        </div>
        <form>
            <div class="form-group">
                <label>Restaurant Name</label>
                <input type="text" class="form-control" value="Brunch">
            </div>
            <div class="form-group">
                <label>Opening Hours</label>
                <input type="text" class="form-control" value="10:00 AM - 2:00 PM">
            </div>
            <div class="form-group">
                <label>Contact Email</label>
                <input type="email" class="form-control" value="Brunch@gmail.com">
            </div>
            <div class="form-group">
                <label>Contact Phone</label>
                <input type="text" class="form-control" value="(555) 123-4567">
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" rows="3">123 Main Street, near Gulberg Lahore</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </section>
</div>

<script src="../js/admin.js"></script>
</body>
</html>