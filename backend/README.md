# Backend Directory

This directory contains the backend logic for the Hospital Management System.

## Directory Structure

```
backend/
├── api/              # API endpoints (RESTful)
├── controllers/      # Request controllers
├── models/           # Database models
├── includes/         # Shared includes (db, auth)
└── helpers/          # Helper functions
```

## API Endpoints

### Authentication
- `POST /backend/api/auth.php?action=login` - User login
- `POST /backend/api/auth.php?action=logout` - User logout
- `GET /backend/api/auth.php` - Check session

### Patients
- `GET /backend/api/patients.php` - Get all patients
- `GET /backend/api/patients.php?id={id}` - Get patient by ID
- `POST /backend/api/patients.php` - Create new patient
- `PUT /backend/api/patients.php?id={id}` - Update patient
- `DELETE /backend/api/patients.php?id={id}` - Delete patient

### Appointments
- `GET /backend/api/appointments.php` - Get all appointments
- `GET /backend/api/appointments.php?date={date}` - Get appointments by date
- `GET /backend/api/appointments.php?id={id}` - Get appointment by ID
- `POST /backend/api/appointments.php` - Create new appointment
- `PUT /backend/api/appointments.php?id={id}` - Update appointment
- `DELETE /backend/api/appointments.php?id={id}` - Delete appointment

## Models

### Available Models
- `PatientModel` - Patient operations
- `DoctorModel` - Doctor operations
- `AppointmentModel` - Appointment operations
- `EmployeeModel` - Employee operations
- `DepartmentModel` - Department operations
- `InvoiceModel` - Invoice operations

## Usage Example

```php
// Using a model
require_once 'backend/models/PatientModel.php';
$patientModel = new PatientModel();
$patients = $patientModel->getAll();

// Using API endpoint
// JavaScript/AJAX example:
fetch('backend/api/patients.php')
    .then(response => response.json())
    .then(data => console.log(data));
```

## Authentication

All API endpoints (except auth.php) require authentication. Include the session cookie or use the authentication helper:

```php
require_once 'backend/includes/auth.php';
requireLogin(); // Redirects to login if not authenticated
```

## Response Format

All API endpoints return JSON:

```json
{
    "success": true,
    "message": "Operation successful",
    "data": { ... }
}
```

Or on error:

```json
{
    "success": false,
    "message": "Error message"
}
```
