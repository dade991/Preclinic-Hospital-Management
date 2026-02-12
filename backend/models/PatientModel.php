<?php
/**
 * Patient Model
 * Handles all database operations for patients
 */

require_once dirname(__DIR__) . '/includes/db.php';

class PatientModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    /**
     * Get all patients
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT * FROM patients WHERE status = 'active' ORDER BY created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        } else {
            $stmt = mysqli_prepare($this->conn, $query);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $patients = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $patients[] = $row;
        }
        
        return $patients;
    }
    
    /**
     * Get patient by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM patients WHERE id = ? AND status = 'active'";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Get patient by patient_id
     */
    public function getByPatientId($patient_id) {
        $query = "SELECT * FROM patients WHERE patient_id = ? AND status = 'active'";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Create new patient
     */
    public function create($data) {
        $query = "INSERT INTO patients (patient_id, first_name, last_name, email, phone, date_of_birth, gender, blood_group, address, city, state, zip_code, emergency_contact_name, emergency_contact_phone) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssssss",
            $data['patient_id'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['date_of_birth'],
            $data['gender'],
            $data['blood_group'],
            $data['address'],
            $data['city'],
            $data['state'],
            $data['zip_code'],
            $data['emergency_contact_name'],
            $data['emergency_contact_phone']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }
        
        return false;
    }
    
    /**
     * Update patient
     */
    public function update($id, $data) {
        $query = "UPDATE patients SET first_name = ?, last_name = ?, email = ?, phone = ?, date_of_birth = ?, gender = ?, blood_group = ?, address = ?, city = ?, state = ?, zip_code = ?, emergency_contact_name = ?, emergency_contact_phone = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssssssssi",
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['date_of_birth'],
            $data['gender'],
            $data['blood_group'],
            $data['address'],
            $data['city'],
            $data['state'],
            $data['zip_code'],
            $data['emergency_contact_name'],
            $data['emergency_contact_phone'],
            $id
        );
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Delete patient (soft delete)
     */
    public function delete($id) {
        $query = "UPDATE patients SET status = 'inactive' WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Generate unique patient ID
     */
    public function generatePatientId() {
        $prefix = 'PAT';
        $date = date('Ymd');
        $random = rand(1000, 9999);
        return $prefix . $date . $random;
    }
    
    /**
     * Get patient count
     */
    public function getCount() {
        $query = "SELECT COUNT(*) as count FROM patients WHERE status = 'active'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
}
?>
