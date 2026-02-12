<?php
/**
 * Validation Helper Functions
 * Common validation functions for form data
 */

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (basic)
 */
function validatePhone($phone) {
    return preg_match('/^[0-9+\-\s()]+$/', $phone);
}

/**
 * Validate date
 */
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validate required fields
 */
function validateRequired($data, $fields) {
    $errors = [];
    foreach ($fields as $field) {
        if (empty($data[$field])) {
            $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
        }
    }
    return $errors;
}

/**
 * Sanitize string
 */
function sanitizeString($string) {
    return htmlspecialchars(strip_tags(trim($string)));
}

/**
 * Sanitize array
 */
function sanitizeArray($array) {
    $sanitized = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $sanitized[$key] = sanitizeArray($value);
        } else {
            $sanitized[$key] = sanitizeString($value);
        }
    }
    return $sanitized;
}
?>
