<?php
/**
 * Patient Controller
 * Handles patient-related requests
 */

require_once dirname(__DIR__) . '/models/PatientModel.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/includes/auth.php';

class PatientController {
    private $model;
    
    public function __construct() {
        $this->model = new PatientModel();
    }
    
    /**
     * Get all patients
     */
    public function index() {
        requireLogin();
        
        $patients = $this->model->getAll();
        sendSuccess('Patients retrieved successfully', $patients);
    }
    
    /**
     * Get patient by ID
     */
    public function show($id) {
        requireLogin();
        
        $patient = $this->model->getById($id);
        if ($patient) {
            sendSuccess('Patient retrieved successfully', $patient);
        } else {
            sendError('Patient not found', 404);
        }
    }
    
    /**
     * Create new patient
     */
    public function create() {
        requireLogin();
        
        $errors = $this->validate($_POST);
        if (!empty($errors)) {
            sendValidationError($errors);
        }
        
        // Generate patient ID if not provided
        if (empty($_POST['patient_id'])) {
            $_POST['patient_id'] = $this->model->generatePatientId();
        }
        
        $id = $this->model->create($_POST);
        if ($id) {
            sendSuccess('Patient created successfully', ['id' => $id]);
        } else {
            sendError('Failed to create patient');
        }
    }
    
    /**
     * Update patient
     */
    public function update($id) {
        requireLogin();
        
        $errors = $this->validate($_POST, $id);
        if (!empty($errors)) {
            sendValidationError($errors);
        }
        
        if ($this->model->update($id, $_POST)) {
            sendSuccess('Patient updated successfully');
        } else {
            sendError('Failed to update patient');
        }
    }
    
    /**
     * Delete patient
     */
    public function delete($id) {
        requireLogin();
        
        if ($this->model->delete($id)) {
            sendSuccess('Patient deleted successfully');
        } else {
            sendError('Failed to delete patient');
        }
    }
    
    /**
     * Validate patient data
     */
    private function validate($data, $id = null) {
        $errors = [];
        
        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        }
        
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        }
        
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        return $errors;
    }
}
?>
