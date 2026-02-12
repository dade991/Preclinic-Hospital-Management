<?php
/**
 * Employee Model
 * Handles all database operations for employees
 */

require_once dirname(__DIR__) . '/includes/db.php';

class EmployeeModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    /**
     * Get all employees
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT e.*, dept.name as department_name 
                  FROM employees e 
                  LEFT JOIN departments dept ON e.department_id = dept.id 
                  WHERE e.status = 'active' 
                  ORDER BY e.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        } else {
            $stmt = mysqli_prepare($this->conn, $query);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $employees = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $employees[] = $row;
        }
        
        return $employees;
    }
    
    /**
     * Get employee by ID
     */
    public function getById($id) {
        $query = "SELECT e.*, dept.name as department_name 
                  FROM employees e 
                  LEFT JOIN departments dept ON e.department_id = dept.id 
                  WHERE e.id = ? AND e.status = 'active'";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Create new employee
     */
    public function create($data) {
        $query = "INSERT INTO employees (user_id, employee_id, first_name, last_name, email, phone, designation, department_id, joining_date, salary, address) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "issssssisds",
            $data['user_id'],
            $data['employee_id'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['designation'],
            $data['department_id'],
            $data['joining_date'],
            $data['salary'],
            $data['address']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }
        
        return false;
    }
    
    /**
     * Update employee
     */
    public function update($id, $data) {
        $query = "UPDATE employees SET first_name = ?, last_name = ?, email = ?, phone = ?, designation = ?, department_id = ?, joining_date = ?, salary = ?, address = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssisdsi",
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['designation'],
            $data['department_id'],
            $data['joining_date'],
            $data['salary'],
            $data['address'],
            $id
        );
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Delete employee (soft delete)
     */
    public function delete($id) {
        $query = "UPDATE employees SET status = 'inactive' WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Generate unique employee ID
     */
    public function generateEmployeeId() {
        $prefix = 'EMP';
        $date = date('Ymd');
        $random = rand(1000, 9999);
        return $prefix . $date . $random;
    }
}
?>
