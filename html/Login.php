<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_chain";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$admin_email = "taha@brunch.com";  // Admin login email

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password_input = $_POST['password'];

    // Escape the email input
    $email = $conn->real_escape_string($email);

    // ✅ FIXED: Use the correct column name "user" instead of "email"
    $sql = "SELECT * FROM users WHERE user = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password_input, $user_data['password'])) {
          $_SESSION['loggedin'] = true;
          $_SESSION['user'] = $email; 
          $_SESSION['role'] = $user_data['role']; 

if ($_SESSION['role'] === 'admin') {
    header("Location: ../html/admin.php");
} else {
    header("Location: ../html/indexhome.php");
            exit();
}
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <span class="picture">
            <img src="../image/food-breakfast-table-healthy.jpg" alt="Breakfast Image">
        </span>
        <div class="side">
            <form class="loginform" action="../html/Login.php" method="POST">
                <h class="heading">Sign in</h>
                <p class="subheading">Welcome back! Please enter your details</p>
                <?php if (!empty($error)): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>
                     <label class="label1" for="email">Email address</label><br>
                <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
                <label class="label2" for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password" required><br>
                <div class="options">
                    <label class="label3">
                        <input type="checkbox" name="remember" checked> Remember me
                    </label>
                    <a id="forgot" href="/forgot-password">Forgot password?</a>
                </div><br><br>
                <button type="submit">Sign in</button>
                <p class="signuptext">Don't have an account? <a id="sign" href="Signup.php">Sign up</a></p>
            </form>
        </div>
    </div>
    <div class="img1">
        <img src="../image/Shape (3).png" alt="Shape2 Image">
    </div>
    <img class="img2" src="../image/Shape (2).png" alt="Shape7Image">
    <img class="img3" src="../image/Shape 1.png" alt="Shape6 Image">
    <div class="image-container">
        <img class="img4" src="../image/shape orange.png" alt="Shape3 Image">
    </div>
    <img class="img5" src="../image/Shape.png" alt="Shape8 Image">
    <img class="img6" src="../image/lines.png" alt="Lines Image">
</body>
</html>