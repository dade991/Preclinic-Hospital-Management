<?php
/**
 * Doctor Model
 * Handles all database operations for doctors
 */

require_once dirname(__DIR__) . '/includes/db.php';

class DoctorModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    /**
     * Get all doctors
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT d.*, dept.name as department_name 
                  FROM doctors d 
                  LEFT JOIN departments dept ON d.department_id = dept.id 
                  WHERE d.status = 'active' 
                  ORDER BY d.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        } else {
            $stmt = mysqli_prepare($this->conn, $query);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $doctors = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = $row;
        }
        
        return $doctors;
    }
    
    /**
     * Get doctor by ID
     */
    public function getById($id) {
        $query = "SELECT d.*, dept.name as department_name 
                  FROM doctors d 
                  LEFT JOIN departments dept ON d.department_id = dept.id 
                  WHERE d.id = ? AND d.status = 'active'";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Create new doctor
     */
    public function create($data) {
        $query = "INSERT INTO doctors (user_id, first_name, last_name, email, phone, specialization, qualification, department_id, experience, consultation_fee, address) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "issssssiids",
            $data['user_id'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['specialization'],
            $data['qualification'],
            $data['department_id'],
            $data['experience'],
            $data['consultation_fee'],
            $data['address']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }
        
        return false;
    }
    
    /**
     * Update doctor
     */
    public function update($id, $data) {
        $query = "UPDATE doctors SET first_name = ?, last_name = ?, email = ?, phone = ?, specialization = ?, qualification = ?, department_id = ?, experience = ?, consultation_fee = ?, address = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssiidsi",
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['specialization'],
            $data['qualification'],
            $data['department_id'],
            $data['experience'],
            $data['consultation_fee'],
            $data['address'],
            $id
        );
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Delete doctor (soft delete)
     */
    public function delete($id) {
        $query = "UPDATE doctors SET status = 'inactive' WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Get doctor count
     */
    public function getCount() {
        $query = "SELECT COUNT(*) as count FROM doctors WHERE status = 'active'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
}
?>
