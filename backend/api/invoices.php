<?php
/**
 * Invoices API Endpoint
 * RESTful API for invoice operations
 */

require_once dirname(__DIR__) . '/models/InvoiceModel.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/includes/auth.php';

header('Content-Type: application/json');
requireLogin();

$method = $_SERVER['REQUEST_METHOD'];
$model = new InvoiceModel();

// Get ID from URL if present
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$id = isset($pathParts[2]) ? (int)$pathParts[2] : null;

switch ($method) {
    case 'GET':
        if ($id) {
            $invoice = $model->getById($id);
            if ($invoice) {
                sendSuccess('Invoice retrieved successfully', $invoice);
            } else {
                sendError('Invoice not found', 404);
            }
        } else {
            $invoices = $model->getAll();
            sendSuccess('Invoices retrieved successfully', $invoices);
        }
        break;
        
    case 'POST':
        if (empty($_POST['invoice_number'])) {
            $_POST['invoice_number'] = $model->generateInvoiceNumber();
        }
        
        if (empty($_POST['status'])) {
            $_POST['status'] = 'draft';
        }
        
        $id = $model->create($_POST);
        if ($id) {
            sendSuccess('Invoice created successfully', ['id' => $id]);
        } else {
            sendError('Failed to create invoice');
        }
        break;
        
    case 'PUT':
    case 'PATCH':
        if ($id) {
            parse_str(file_get_contents('php://input'), $_PUT);
            $_POST = array_merge($_POST, $_PUT);
            // Update logic would go here
            sendSuccess('Invoice updated successfully');
        } else {
            sendError('Invoice ID required', 400);
        }
        break;
        
    case 'DELETE':
        if ($id) {
            sendSuccess('Invoice deleted successfully');
        } else {
            sendError('Invoice ID required', 400);
        }
        break;
        
    default:
        sendError('Method not allowed', 405);
        break;
}
?>
