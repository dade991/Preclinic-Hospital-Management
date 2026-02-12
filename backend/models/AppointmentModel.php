<?php
/**
 * Appointment Model
 * Handles all database operations for appointments
 */

require_once dirname(__DIR__) . '/includes/db.php';

class AppointmentModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    /**
     * Get all appointments
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, 
                         d.first_name as doctor_first_name, d.last_name as doctor_last_name
                  FROM appointments a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        
        if ($limit) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        } else {
            $stmt = mysqli_prepare($this->conn, $query);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
        
        return $appointments;
    }
    
    /**
     * Get appointment by ID
     */
    public function getById($id) {
        $query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, 
                         d.first_name as doctor_first_name, d.last_name as doctor_last_name
                  FROM appointments a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  WHERE a.id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Create new appointment
     */
    public function create($data) {
        $query = "INSERT INTO appointments (appointment_number, patient_id, doctor_id, appointment_date, appointment_time, reason, status, notes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "siisssss",
            $data['appointment_number'],
            $data['patient_id'],
            $data['doctor_id'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['reason'],
            $data['status'],
            $data['notes']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            return mysqli_insert_id($this->conn);
        }
        
        return false;
    }
    
    /**
     * Update appointment
     */
    public function update($id, $data) {
        $query = "UPDATE appointments SET patient_id = ?, doctor_id = ?, appointment_date = ?, appointment_time = ?, reason = ?, status = ?, notes = ? WHERE id = ?";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "iisssssi",
            $data['patient_id'],
            $data['doctor_id'],
            $data['appointment_date'],
            $data['appointment_time'],
            $data['reason'],
            $data['status'],
            $data['notes'],
            $id
        );
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Delete appointment
     */
    public function delete($id) {
        $query = "DELETE FROM appointments WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Generate unique appointment number
     */
    public function generateAppointmentNumber() {
        $prefix = 'APT';
        $date = date('Ymd');
        $random = rand(1000, 9999);
        return $prefix . $date . $random;
    }
    
    /**
     * Get appointments by date
     */
    public function getByDate($date) {
        $query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, 
                         d.first_name as doctor_first_name, d.last_name as doctor_last_name
                  FROM appointments a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  WHERE a.appointment_date = ?
                  ORDER BY a.appointment_time ASC";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $date);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $appointments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $appointments[] = $row;
        }
        
        return $appointments;
    }
}
?>
