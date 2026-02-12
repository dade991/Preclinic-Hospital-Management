<?php
/**
 * Doctor Controller
 * Handles doctor-related requests
 */

require_once dirname(__DIR__) . '/models/DoctorModel.php';
require_once dirname(__DIR__) . '/helpers/response.php';
require_once dirname(__DIR__) . '/includes/auth.php';

class DoctorController {
    private $model;
    
    public function __construct() {
        $this->model = new DoctorModel();
    }
    
    /**
     * Get all doctors
     */
    public function index() {
        requireLogin();
        
        $doctors = $this->model->getAll();
        sendSuccess('Doctors retrieved successfully', $doctors);
    }
    
    /**
     * Get doctor by ID
     */
    public function show($id) {
        requireLogin();
        
        $doctor = $this->model->getById($id);
        if ($doctor) {
            sendSuccess('Doctor retrieved successfully', $doctor);
        } else {
            sendError('Doctor not found', 404);
        }
    }
    
    /**
     * Create new doctor
     */
    public function create() {
        requireLogin();
        
        $errors = $this->validate($_POST);
        if (!empty($errors)) {
            sendValidationError($errors);
        }
        
        $id = $this->model->create($_POST);
        if ($id) {
            sendSuccess('Doctor created successfully', ['id' => $id]);
        } else {
            sendError('Failed to create doctor');
        }
    }
    
    /**
     * Update doctor
     */
    public function update($id) {
        requireLogin();
        
        $errors = $this->validate($_POST, $id);
        if (!empty($errors)) {
            sendValidationError($errors);
        }
        
        if ($this->model->update($id, $_POST)) {
            sendSuccess('Doctor updated successfully');
        } else {
            sendError('Failed to update doctor');
        }
    }
    
    /**
     * Delete doctor
     */
    public function delete($id) {
        requireLogin();
        
        if ($this->model->delete($id)) {
            sendSuccess('Doctor deleted successfully');
        } else {
            sendError('Failed to delete doctor');
        }
    }
    
    /**
     * Validate doctor data
     */
    private function validate($data, $id = null) {
        $errors = [];
        
        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First name is required';
        }
        
        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last name is required';
        }
        
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        return $errors;
    }
}
?>
