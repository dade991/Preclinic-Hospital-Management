<?php
require_once "config.php";
require_once "backend/includes/auth.php";

// If user is already logged in, send them to the dashboard
if (isLoggedIn()) {
    redirect('index-2.php');
}

$errors = [];
$success = '';

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? sanitize_input($_POST['username']) : '';
    $email    = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $phone    = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';

    // Basic validation
    if ($username === '') {
        $errors['username'] = 'Username is required';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required';
    }
    if ($password === '' || strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    if (empty($errors)) {
        // Check if username or email already exists
        $checkQuery = "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_fetch_assoc($result)) {
            $errors['exists'] = 'Username or email already exists';
        } else {
            // Create user
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $full_name = $username;
            $role = 'admin'; // default role for this project

            $insertQuery = "INSERT INTO users (username, email, password, full_name, role, phone, status)
                            VALUES (?, ?, ?, ?, ?, ?, 'active')";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $hashedPassword, $full_name, $role, $phone);

            if (mysqli_stmt_execute($stmt)) {
                // Auto-login after registration
                loginUser($username, $password);
                redirect('index-2.php');
            } else {
                $errors['general'] = 'Failed to create account. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- register24:03-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System - Register</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper  account-wrapper">
        <div class="account-page">
            <div class="account-center">
                <div class="account-box">
                    <form action="register.php" method="POST" class="form-signin">
						<div class="account-logo">
                            <a href="index-2.php"><img src="assets/img/logo-dark.png" alt=""></a>
                        </div>
                        <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($errors as $msg): ?>
                                <div><?php echo $msg; ?></div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="form-group checkbox">
                            <label>
                                <input type="checkbox"> I have read and agree the Terms & Conditions
                            </label>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary account-btn" type="submit">Signup</button>
                        </div>
                        <div class="text-center login-link">
                            Already have an account? <a href="login.php">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>


<!-- register24:03-->
</html>