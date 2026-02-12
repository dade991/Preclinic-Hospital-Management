<?php
/**
 * Department Model
 * Handles all database operations for departments
 */

require_once dirname(__DIR__) . '/includes/db.php';

class DepartmentModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    /**
     * Get all departments
     */
    public function getAll() {
        $query = "SELECT * FROM departments WHERE status = 'active' ORDER BY name ASC";
        $result = mysqli_query($this->conn, $query);
        
        $departments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $departments[] = $row;
        }
        
        return $departments;
    }
    
    /**
     * Get department by ID
     */
    public function getById($id) {
        $query = "SELECT * FROM departments WHERE id = ? AND status = 'active'";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Create new department
     */
    public function create($data) {
        $query = "INSERT INTO departments (name, description, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sss",
            $data['name'],
            $data['description'],
            $data['status']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }
        
        return false;
    }
    
    /**
     * Update department
     */
    public function update($id, $data) {
        $query = "UPDATE departments SET name = ?, description = ?, status = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi",
            $data['name'],
            $data['description'],
            $data['status'],
            $id
        );
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Delete department (soft delete)
     */
    public function delete($id) {
        $query = "UPDATE departments SET status = 'inactive' WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        return mysqli_stmt_execute($stmt);
    }
}
?>
