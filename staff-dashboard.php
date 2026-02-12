<?php
require_once "config.php";
require_once "backend/includes/auth.php";

// Staff area requires login
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>Hospital Management System - Staff Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="staff-dashboard.php" class="logo">
                    <img src="assets/img/logo.png" width="35" height="35" alt=""> <span>Hospital</span>
                </a>
            </div>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
							<img class="rounded-circle" src="assets/img/user.jpg" width="24" alt="Staff">
						</span>
						<span><?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Staff'; ?></span>
                    </a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="profile.php">My Profile</a>
						<a class="dropdown-item" href="login.php">Logout</a>
					</div>
                </li>
            </ul>
        </div>
        <div class="page-wrapper">
            <div class="content container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="page-title">Staff Dashboard</h3>
                        <p>Welcome to the staff dashboard. From here you can manage patients, appointments and billing.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Patients</h4>
                                <p>View and manage patient records.</p>
                                <a href="patients.php" class="btn btn-primary btn-block">Manage Patients</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Appointments</h4>
                                <p>Schedule and manage appointments.</p>
                                <a href="appointments.php" class="btn btn-primary btn-block">Manage Appointments</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Invoices</h4>
                                <p>Create and review patient invoices.</p>
                                <a href="invoices.php" class="btn btn-primary btn-block">Manage Invoices</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Calendar</h4>
                                <p>Check the appointment calendar.</p>
                                <a href="calendar.php" class="btn btn-primary btn-block">View Calendar</a>
                            </div>
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

