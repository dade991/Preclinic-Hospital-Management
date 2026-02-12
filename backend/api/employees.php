<?php
/**
 * Employees API Endpoint
 * RESTful API for employee operations
 */

require_once dirname(__DIR__) . '/models/EmployeeModel.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/includes/auth.php';

header('Content-Type: application/json');
requireLogin();

$method = $_SERVER['REQUEST_METHOD'];
$model = new EmployeeModel();

// Get ID from URL if present
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$id = isset($pathParts[2]) ? (int)$pathParts[2] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            $employee = $model->getById($id);
            if ($employee) {
                sendSuccess('Employee retrieved successfully', $employee);
            } else {
                sendError('Employee not found', 404);
            }
        } else {
            $employees = $model->getAll();
            sendSuccess('Employees retrieved successfully', $employees);
        }
        break;
        
    case 'POST':
        if (empty($_POST['employee_id'])) {
            $_POST['employee_id'] = $model->generateEmployeeId();
        }
        
        $id = $model->create($_POST);
        if ($id) {
            sendSuccess('Employee created successfully', ['id' => $id]);
        } else {
            sendError('Failed to create employee');
        }
        break;
        
    case 'PUT':
    case 'PATCH':
        if ($id) {
            parse_str(file_get_contents('php://input'), $_PUT);
            $_POST = array_merge($_POST, $_PUT);
            if ($model->update($id, $_POST)) {
                sendSuccess('Employee updated successfully');
            } else {
                sendError('Failed to update employee');
            }
        } else {
            sendError('Employee ID required', 400);
        }
        break;
        
    case 'DELETE':
        if ($id) {
            if ($model->delete($id)) {
                sendSuccess('Employee deleted successfully');
            } else {
                sendError('Failed to delete employee');
            }
        } else {
            sendError('Employee ID required', 400);
        }
        break;
        
    default:
        sendError('Method not allowed', 405);
        break;
}
?>
