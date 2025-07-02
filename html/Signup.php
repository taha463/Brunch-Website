<?php
session_start();

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "food_chain";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($user_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        try {
            $conn = new mysqli($servername, $db_username, $db_password, $dbname);
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Check if email already exists
            $check_stmt = $conn->prepare("SELECT id FROM users WHERE user = ?");
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $error = "Email already exists!";
            } else {
                // Insert new user
                $stmt = $conn->prepare("INSERT INTO users (user, password) VALUES (?, ?)");
                $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
                $stmt->bind_param("ss", $email, $hashed_password);

                if ($stmt->execute()) {
                    header("Location: ../html/Login.php");
                    exit();
                } else {
                    throw new Exception("Insert failed: " . $conn->error);
                }
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($check_stmt)) $check_stmt->close();
            if (isset($conn)) $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/Signup.css">
    <style>
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <span class="picture"><img src="../image/Brunch.jpg" alt=""></span>
        <div class="side">
            <form class="loginform" action="Signup.php" method="POST">
                <h class="heading">Sign up</h>
                <p class="subheading">Welcome Brunch! Please enter your details</p>
                
                <?php if ($error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <label class="label1" for="email">Email address</label><br>
                <input type="email" id="email" name="email" placeholder="Enter your email" required><br>
                
                <label class="label2" for="password">Password</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password" required><br>
                
                <label class="label4" for="confirm_password">Confirm Password</label><br>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br>
                
                <button type="submit">Sign up</button>
                
                <p class="signuptext">Already have an account? 
                    <a id="sign" href="../html/Login.php">Sign in</a>
                </p>
            </form>
        </div>
    </div>
    
    <!-- Your image elements -->
    <div class="img1"><img src="../image/Shape (3).png" alt=""></div>
    <img class="img2" src="../image/Shape (2).png" alt="">
    <img class="img3" src="../image/Shape 1.png" alt="">
    <div class="image-container"><img class="../image/img4" src="shape orange.png" alt=""></div>
    <img class="img5" src="../image/Shape.png" alt="">
    <img class="img6" src="../image/lines.png" alt="">
</body>
</html>