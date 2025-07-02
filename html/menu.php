<?php
session_start();

// DB Connection (optional, for session management)
$conn = new mysqli("localhost", "root", "", "food_chain");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch menu files
$menuDir = '../images';
if (!is_dir($menuDir)) {
    mkdir($menuDir, 0777, true); // Create directory if it doesn't exist
}
$menuFiles = is_dir($menuDir) ? array_diff(scandir($menuDir), ['.', '..']) : [];
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Brunch</title>
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <section id="Home">
        <header class="header">
            <nav class="navbar">
                <div class="nav-left">
                    <a href="../html/indexhome.php">Home</a>
                    <a href="../html/Blog.php">Blog</a> <!-- Corrected typo from "Блог" -->
                    <a href="../html/menu.php">Menu</a>
                    <a href="../html/indexhome.php#Branch">Branch</a>
                </div>
                <a href="../html/indexhome.php"><img class="img1" src="../image/Place Your Logo Here (Double Click to Edit).png" alt="Logo"></a>
                <div class="nav-right">
                    <a href="../html/indexhome.php#About">About</a>
                    <a href="../html/indexhome.php#Contact">Contact</a>

                   <?php if (isset($_SESSION['loggedin']) && $_SESSION['role'] === 'user'):?>

                        <button class="book-btn22" onclick="window.location.href='../html/Booking.php'">Book Table</button>
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-icon" id="userIcon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="dropdown-content">
                                <div class="dropdown-menu">
                                    <a href="../html/logout.php" class="logout-btn">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <button class="Login" onclick="window.location.href='../html/Login.php'">Sign in</button>
                    <?php endif; ?>
                    <img class="btn1" src="../image/sun.svg" alt="Toggle Theme">
                </div>
            </nav>
        </header>
    </section>

    <div class="menu-container">
        <div class="section-header">
            <h2>Our Menu</h2>
        </div>
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
                        <a href="<?php echo htmlspecialchars($publicPath); ?>" target="_blank" class="menu-action-btn view-btn">
                            <i class="fas fa-file-download"></i> Download
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-utensils"></i>
                <h3>No Menu for <?php echo ucfirst($day); ?></h3>
                <p>Please check back later for our <?php echo ucfirst($day); ?> menu.</p>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
    </div>


    <section class="footer">
        <span class="container15">
            <img class="img20" src="../image/Place Your Logo Here (Double Click to Edit).png">
            <span class="text29">
                <h3>Your Company</h3>
                <p>President street 25<br> New York, USA<br>12850</p>
                <a href="www.Brunch.com">www.Brunch.com</a>
            </span>
            <div class="link1">
                <h3>Quick Links</h3>
                <a href="../html/indexhome.php indexhome.php">Home</a>
                <a href="../html/indexhome.php #About">About</a>
                <a href="../html/indexhome.php #blog">Blog</a>
                <a href="../html/indexhome.php #Menu">Menu</a>
            </div>
            <div class="link2">
                <h3>Sitelink</h3>
                <a href="../html/indexhome.php #Shop">Shop</a>
                <a href="../html/indexhome.php #Contact">Contact</a>
                <a href="../html/Login.php">Sign in</a>
                <a href="../html/Signup.php">Sign up</a>
            </div>
            <div class="link3">
                <h3>Sitemap</h3>
                <a href="../html/readmore.php">Read More</a>
                <a href="../html/menu.php">Full Menu</a>
                <a href="../html/Booking.php">Booking Now</a>
                <a href="../html/Blog.php">Full Blog</a>
            </div>
            <img class="img21" src="../image/Place Your Logo Here (Double Click to Edit).png">
            <p class="text20">Copyright © 2020 Freepik<br> Company S.L. All rights reserved.</p>
            <span class="img27">
                <img src="../image/facebook.png">
                <img src="../image/instagram.png">
                <img src="../image/twitter.png">
            </span>
        </span>
    </section>

    <script src="../js/menu.js"></script>
    <script src="../js/dropdown.js"></script>
</body>
</html>