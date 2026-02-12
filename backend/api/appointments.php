<?php
/**
 * Appointments API Endpoint
 * RESTful API for appointment operations
 */

require_once dirname(__DIR__) . '/models/AppointmentModel.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/includes/auth.php';

header('Content-Type: application/json');
requireLogin();

$method = $_SERVER['REQUEST_METHOD'];
$model = new AppointmentModel();

// Get ID from URL if present
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$id = isset($pathParts[2]) ? (int)$pathParts[2] : null;

switch ($method) {
    case 'GET':
        if (isset($_GET['date'])) {
            $appointments = $model->getByDate($_GET['date']);
            sendSuccess('Appointments retrieved successfully', $appointments);
        } elseif ($id) {
            $appointment = $model->getById($id);
            if ($appointment) {
                sendSuccess('Appointment retrieved successfully', $appointment);
            } else {
                sendError('Appointment not found', 404);
            }
        } else {
            $appointments = $model->getAll();
            sendSuccess('Appointments retrieved successfully', $appointments);
        }
        break;
        
    case 'POST':
        if (empty($_POST['appointment_number'])) {
            $_POST['appointment_number'] = $model->generateAppointmentNumber();
        }
        
        $id = $model->create($_POST);
        if ($id) {
            sendSuccess('Appointment created successfully', ['id' => $id]);
        } else {
            sendError('Failed to create appointment');
        }
        break;
        
    case 'PUT':
    case 'PATCH':
        if ($id) {
            parse_str(file_get_contents('php://input'), $_PUT);
            $_POST = array_merge($_POST, $_PUT);
            if ($model->update($id, $_POST)) {
                sendSuccess('Appointment updated successfully');
            } else {
                sendError('Failed to update appointment');
            }
        } else {
            sendError('Appointment ID required', 400);
        }
        break;
        
    case 'DELETE':
        if ($id) {
            if ($model->delete($id)) {
                sendSuccess('Appointment deleted successfully');
            } else {
                sendError('Failed to delete appointment');
            }
        } else {
            sendError('Appointment ID required', 400);
        }
        break;
        
    default:
        sendError('Method not allowed', 405);
        break;
}
?>
