<?php require_once "config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System - Home</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
    <div class="main-wrapper landing-main">
        <div class="header landing-header">
            <div class="header-left">
                <a href="index.php" class="logo">
                    <img src="assets/img/logo.png" width="35" height="35" alt=""> <span>Hospital</span>
                </a>
            </div>
            <ul class="nav user-menu float-right">
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Patient Login</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">Patient Register</a>
                </li>
                <li class="nav-item">
                    <a href="staff-login.php" class="nav-link">Staff / Admin</a>
                </li>
            </ul>
        </div>
        <div class="page-wrapper landing-wrapper">
            <div class="content container">
                <div class="landing-hero">
                    <h1>Hospital Management System</h1>
                    <p>
                        A clean, offline-ready academic project for managing patients, staff, appointments and billing
                        in a modern hospital environment.
                    </p>
                    <div class="m-t-30">
                        <a href="login.php" class="btn btn-primary btn-lg m-r-10">Patient Login</a>
                        <a href="register.php" class="btn btn-outline-primary btn-lg">Create Patient Account</a>
                    </div>
                </div>
                <div class="row m-t-40">
                    <div class="col-md-4">
                        <div class="role-card">
                            <h4>Patients</h4>
                            <p>Securely manage your profile, view upcoming appointments and track your billing history.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="role-card">
                            <h4>Staff</h4>
                            <p>Staff members can manage patients, appointments and daily operations in one place.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="role-card">
                            <h4>Administration</h4>
                            <p>Admins have full control over departments, users, payroll, reporting and system settings.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>

