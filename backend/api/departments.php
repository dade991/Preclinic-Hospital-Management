<?php
/**
 * Departments API Endpoint
 * RESTful API for department operations
 */

require_once dirname(__DIR__) . '/models/DepartmentModel.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/includes/auth.php';

header('Content-Type: application/json');
requireLogin();

$method = $_SERVER['REQUEST_METHOD'];
$model = new DepartmentModel();

// Get ID from URL if present
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$id = isset($pathParts[2]) ? (int)$pathParts[2] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            $department = $model->getById($id);
            if ($department) {
                sendSuccess('Department retrieved successfully', $department);
            } else {
                sendError('Department not found', 404);
            }
        } else {
            $departments = $model->getAll();
            sendSuccess('Departments retrieved successfully', $departments);
        }
        break;
        
    case 'POST':
        if (empty($_POST['status'])) {
            $_POST['status'] = 'active';
        }
        
        $id = $model->create($_POST);
        if ($id) {
            sendSuccess('Department created successfully', ['id' => $id]);
        } else {
            sendError('Failed to create department');
        }
        break;
        
    case 'PUT':
    case 'PATCH':
        if ($id) {
            parse_str(file_get_contents('php://input'), $_PUT);
            $_POST = array_merge($_POST, $_PUT);
            if ($model->update($id, $_POST)) {
                sendSuccess('Department updated successfully');
            } else {
                sendError('Failed to update department');
            }
        } else {
            sendError('Department ID required', 400);
        }
        break;
        
    case 'DELETE':
        if ($id) {
            if ($model->delete($id)) {
                sendSuccess('Department deleted successfully');
            } else {
                sendError('Failed to delete department');
            }
        } else {
            sendError('Department ID required', 400);
        }
        break;
        
    default:
        sendError('Method not allowed', 405);
        break;
}
?>
