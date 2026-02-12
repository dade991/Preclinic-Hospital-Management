<?php
/**
 * Authentication API Endpoint
 * Handles login, logout, and session management
 */

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/helpers/response.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        // Login
        if (isset($_POST['action']) && $_POST['action'] === 'login') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                sendError('Username and password are required', 400);
            }
            
            if (loginUser($username, $password)) {
                $user = getCurrentUser();
                sendSuccess('Login successful', [
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'full_name' => $user['full_name'],
                        'role' => $user['role']
                    ]
                ]);
            } else {
                sendError('Invalid username or password', 401);
            }
        }
        
        // Logout
        elseif (isset($_POST['action']) && $_POST['action'] === 'logout') {
            logoutUser();
            sendSuccess('Logout successful');
        }
        
        else {
            sendError('Invalid action', 400);
        }
        break;
        
    case 'GET':
        // Check session
        if (isLoggedIn()) {
            $user = getCurrentUser();
            sendSuccess('User is logged in', [
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ]
            ]);
        } else {
            sendError('User is not logged in', 401);
        }
        break;
        
    default:
        sendError('Method not allowed', 405);
        break;
}
?>
