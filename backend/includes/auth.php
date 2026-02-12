<?php
/**
 * Authentication Helper Functions
 * Handles user authentication and session management
 */

require_once dirname(__DIR__) . '/../config.php';

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Get current user data
 */
function getCurrentUser() {
    global $conn;
    if (!isLoggedIn()) {
        return null;
    }
    
    $user_id = getCurrentUserId();
    $query = "SELECT * FROM users WHERE id = ? AND status = 'active'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

/**
 * Login user
 */
function loginUser($username, $password) {
    global $conn;
    
    $query = "SELECT * FROM users WHERE (username = ? OR email = ?) AND status = 'active'";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];
        return true;
    }
    
    return false;
}

/**
 * Logout user
 */
function logoutUser() {
    session_unset();
    session_destroy();
}

/**
 * Check user role
 */
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Require login - redirect if not logged in
 * Uses BASE_URL so it works correctly from any directory
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $loginUrl = defined('BASE_URL') ? BASE_URL . 'login.php' : 'login.php';
        header("Location: " . $loginUrl);
        exit();
    }
}

/**
 * Require specific role
 */
function requireRole($role) {
    requireLogin();
    if (!hasRole($role)) {
        header("Location: ../error-403.php");
        exit();
    }
}
?>
