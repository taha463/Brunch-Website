<?php
session_start();
session_unset();
session_destroy();
// Redirect back to home page instead of Login.php
header("Location: ../html/indexhome.php");
exit();
?>