<?php
/**
 * Patients API Endpoint
 * RESTful API for patient operations
 */

require_once dirname(__DIR__) . '/controllers/PatientController.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$controller = new PatientController();

// Get ID from URL if present
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$id = isset($pathParts[2]) ? (int)$pathParts[2] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            $controller->show($id);
        } else {
            $controller->index();
        }
        break;
        
    case 'POST':
        $controller->create();
        break;
        
    case 'PUT':
    case 'PATCH':
        if ($id) {
            parse_str(file_get_contents('php://input'), $_PUT);
            $_POST = array_merge($_POST, $_PUT);
            $controller->update($id);
        } else {
            sendError('Patient ID required', 400);
        }
        break;
        
    case 'DELETE':
        if ($id) {
            $controller->delete($id);
        } else {
            sendError('Patient ID required', 400);
        }
        break;
        
    default:
        sendError('Method not allowed', 405);
        break;
}
?>
