# Installation Guide

## Quick Start

1. **Import Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click "Import" tab
   - Choose file: `database.sql`
   - Click "Go"
   - Database `hospital_management` will be created with all tables

2. **Configure Database** (if needed)
   - Edit `config.php`
   - Update database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');      // Your MySQL username
     define('DB_PASS', '');          // Your MySQL password
     define('DB_NAME', 'hospital_management');
     ```

3. **Access the System**
   - Open browser: `http://localhost/Preclinic-Hospital-Bootstrap4-Admin`
   - Login with:
     - Username: `admin`
     - Password: `admin123`

## System Requirements

- PHP 7.0+
- MySQL 5.7+
- Apache Web Server
- Modern Browser (Chrome, Firefox, Edge)

## Troubleshooting

### Database Connection Error
- Check if MySQL is running
- Verify credentials in `config.php`
- Ensure database `hospital_management` exists

### Page Not Found
- Check Apache is running
- Verify file paths are correct
- Check `.htaccess` if using URL rewriting

### Permission Issues
- Ensure PHP has write permissions for uploads
- Check file permissions (755 for folders, 644 for files)

## Next Steps

1. Change default admin password
2. Add your hospital information
3. Create departments
4. Add doctors and employees
5. Start managing patients and appointments

---

**Ready to use!** All external links removed, all files converted to PHP, database ready to import.
