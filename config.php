<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hospital_management');

// First connect without selecting database to check if MySQL is running
$temp_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS);

if (!$temp_conn) {
    die("Database connection failed: " . mysqli_connect_error() . "<br>Please ensure MySQL is running in XAMPP.");
}

// Check if database exists, if not show helpful message
$db_check = mysqli_select_db($temp_conn, DB_NAME);
if (!$db_check) {
    mysqli_close($temp_conn);
    die("Database '" . DB_NAME . "' does not exist.<br><br>" .
        "Please import the database.sql file:<br>" .
        "1. Open phpMyAdmin (http://localhost/phpmyadmin)<br>" .
        "2. Click 'Import' tab<br>" .
        "3. Choose file: database.sql<br>" .
        "4. Click 'Go'<br><br>" .
        "Or create the database manually and import the SQL file.");
}

// Now create the actual connection with database selected
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL (adjust if needed)
define('BASE_URL', 'http://localhost/Preclinic-Hospital-Bootstrap4-Admin/');

// Helper function to sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

// Helper function to redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Check if user is logged in (for protected pages)
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}
?>
