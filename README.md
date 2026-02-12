 # Hospital Management System

A comprehensive Hospital Management System built with PHP, MySQL, and Bootstrap 4. This system is designed for managing hospital operations including patient records, appointments, doctors, employees, billing, and more.

## Features

- **Patient Management**: Complete patient registration and record management
- **Doctor Management**: Doctor profiles, schedules, and specializations
- **Appointment System**: Book and manage patient appointments
- **Employee Management**: Employee records, attendance, and leave management
- **Billing & Invoicing**: Generate invoices and track payments
- **Department Management**: Organize hospital departments
- **Reports**: Generate expense and invoice reports
- **Blog System**: Publish and manage blog posts
- **Asset Management**: Track hospital assets
- **Payroll System**: Manage employee salaries and provident funds

## Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Apache Web Server (XAMPP recommended)
- Modern web browser

## Installation

1. **Extract the files** to your web server directory:
   - For XAMPP: `C:\xampp\htdocs\Preclinic-Hospital-Bootstrap4-Admin`
   - For WAMP: `C:\wamp\www\Preclinic-Hospital-Bootstrap4-Admin`
   - For Linux: `/var/www/html/Preclinic-Hospital-Bootstrap4-Admin`

2. **Create the database**:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `database.sql` file
   - This will create the database `hospital_management` with all required tables

3. **Configure the database connection**:
   - Open `config.php`
   - Update the database credentials if needed:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'hospital_management');
     ```

4. **Access the application**:
   - Open your browser and navigate to: `http://localhost/Preclinic-Hospital-Bootstrap4-Admin`
   - Default login credentials:
     - Username: `admin`
     - Password: `admin123`

## Default Login

- **Username**: admin
- **Password**: admin123

**Important**: Change the default password after first login!

## Database Structure

The system includes the following main tables:

- `users` - System users and administrators
- `patients` - Patient records
- `doctors` - Doctor information
- `appointments` - Appointment bookings
- `employees` - Employee records
- `departments` - Hospital departments
- `invoices` - Billing and invoices
- `payments` - Payment records
- `expenses` - Expense tracking
- `leaves` - Employee leave requests
- `attendance` - Employee attendance
- `salaries` - Salary management
- `assets` - Asset tracking
- `blog` - Blog posts
- And more...

## File Structure

```
Preclinic-Hospital-Bootstrap4-Admin/
├── assets/              # CSS, JS, images
├── includes/            # PHP includes
├── pages/               # Additional pages
├── auth/                # Authentication pages
├── config.php          # Database configuration
├── database.sql         # Database structure
├── index.php           # Main dashboard
├── login.php           # Login page
└── ...                 # Other PHP files
```

## Features Overview

### Dashboard
- Overview statistics
- Recent appointments
- New patients
- Doctor availability

### Patient Management
- Add/Edit patient records
- View patient history
- Generate patient IDs

### Appointment System
- Book appointments
- View appointment calendar
- Manage appointment status

### Doctor Management
- Doctor profiles
- Specializations
- Schedule management
- Consultation fees

### Employee Management
- Employee records
- Attendance tracking
- Leave management
- Holiday calendar

### Billing & Finance
- Invoice generation
- Payment tracking
- Expense management
- Tax calculations

### Reports
- Expense reports
- Invoice reports
- Financial summaries

## Security Notes

1. **Change default passwords** immediately after installation
2. **Update database credentials** in `config.php`
3. **Use HTTPS** in production environments
4. **Regular backups** of the database
5. **Keep PHP updated** for security patches

## Support

For issues or questions:
1. Check the database connection in `config.php`
2. Ensure all files are uploaded correctly
3. Verify PHP and MySQL versions meet requirements
4. Check Apache error logs for detailed error messages



## Credits

- Bootstrap 4
- Font Awesome
- jQuery
- Chart.js



