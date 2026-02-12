<?php
/**
 * Database Connection File
 * Centralized database connection for backend operations
 */

require_once dirname(__DIR__) . '/../config.php';

// Return connection object
function getDBConnection() {
    global $conn;
    return $conn;
}

// Close database connection
function closeDBConnection() {
    global $conn;
    if (isset($conn)) {
        mysqli_close($conn);
    }
}
?>
