<?php
/**
 * Invoice Model
 * Handles all database operations for invoices
 */

require_once dirname(__DIR__) . '/includes/db.php';

class InvoiceModel {
    private $conn;
    
    public function __construct() {
        $this->conn = getDBConnection();
    }
    
    /**
     * Get all invoices
     */
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT i.*, p.first_name as patient_first_name, p.last_name as patient_last_name 
                  FROM invoices i
                  LEFT JOIN patients p ON i.patient_id = p.id
                  ORDER BY i.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        } else {
            $stmt = mysqli_prepare($this->conn, $query);
        }
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $invoices = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $invoices[] = $row;
        }
        
        return $invoices;
    }
    
    /**
     * Get invoice by ID with items
     */
    public function getById($id) {
        $query = "SELECT i.*, p.first_name as patient_first_name, p.last_name as patient_last_name 
                  FROM invoices i
                  LEFT JOIN patients p ON i.patient_id = p.id
                  WHERE i.id = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $invoice = mysqli_fetch_assoc($result);
        
        if ($invoice) {
            // Get invoice items
            $itemsQuery = "SELECT * FROM invoice_items WHERE invoice_id = ?";
            $itemsStmt = mysqli_prepare($this->conn, $itemsQuery);
            mysqli_stmt_bind_param($itemsStmt, "i", $id);
            mysqli_stmt_execute($itemsStmt);
            $itemsResult = mysqli_stmt_get_result($itemsStmt);
            
            $invoice['items'] = [];
            while ($item = mysqli_fetch_assoc($itemsResult)) {
                $invoice['items'][] = $item;
            }
        }
        
        return $invoice;
    }
    
    /**
     * Create new invoice
     */
    public function create($data) {
        $query = "INSERT INTO invoices (invoice_number, patient_id, appointment_id, invoice_date, due_date, subtotal, tax_amount, discount, total_amount, status, notes) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "siisddddds",
            $data['invoice_number'],
            $data['patient_id'],
            $data['appointment_id'],
            $data['invoice_date'],
            $data['due_date'],
            $data['subtotal'],
            $data['tax_amount'],
            $data['discount'],
            $data['total_amount'],
            $data['status'],
            $data['notes']
        );
        
        if (mysqli_stmt_execute($stmt)) {
            $invoice_id = mysqli_insert_id($this->conn);
            
            // Insert invoice items if provided
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $this->addItem($invoice_id, $item);
                }
            }
            
            return $invoice_id;
        }
        
        return false;
    }
    
    /**
     * Add item to invoice
     */
    public function addItem($invoice_id, $item) {
        $query = "INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "isidd",
            $invoice_id,
            $item['description'],
            $item['quantity'],
            $item['unit_price'],
            $item['total']
        );
        
        return mysqli_stmt_execute($stmt);
    }
    
    /**
     * Generate unique invoice number
     */
    public function generateInvoiceNumber() {
        $prefix = 'INV';
        $date = date('Ymd');
        $random = rand(1000, 9999);
        return $prefix . $date . $random;
    }
}
?>
