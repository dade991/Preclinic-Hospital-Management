<?php
/**
 * Response Helper Functions
 * Standardized JSON responses for API endpoints
 */

/**
 * Send JSON response
 */
function sendResponse($success, $message, $data = null, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    echo json_encode($response);
    exit();
}

/**
 * Send success response
 */
function sendSuccess($message, $data = null) {
    sendResponse(true, $message, $data, 200);
}

/**
 * Send error response
 */
function sendError($message, $statusCode = 400) {
    sendResponse(false, $message, null, $statusCode);
}

/**
 * Send validation error
 */
function sendValidationError($errors) {
    sendResponse(false, 'Validation failed', ['errors' => $errors], 422);
}
?>
