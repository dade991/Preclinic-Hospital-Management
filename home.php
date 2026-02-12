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
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="home.php" class="logo">
                    <img src="assets/img/logo.png" width="35" height="35" alt=""> <span>Hospital</span>
                </a>
            </div>
            <ul class="nav user-menu float-right">
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">Register</a>
                </li>
            </ul>
        </div>
        <div class="page-wrapper">
            <div class="content container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h1 class="m-t-40">Hospital Management System</h1>
                        <p class="lead m-t-20">
                            A simple academic project for managing patients, doctors, appointments, billing and staff
                            in a hospital environment.
                        </p>
                        <div class="m-t-30">
                            <a href="login.php" class="btn btn-primary btn-lg m-r-10">Login</a>
                            <a href="register.php" class="btn btn-outline-primary btn-lg">Register</a>
                        </div>
                        <hr class="m-t-40 m-b-40">
                        <div class="row text-left">
                            <div class="col-md-4">
                                <h4>Patients</h4>
                                <p>Register patients, manage records and keep track of visits.</p>
                            </div>
                            <div class="col-md-4">
                                <h4>Doctors</h4>
                                <p>Maintain doctor profiles, specializations and schedules.</p>
                            </div>
                            <div class="col-md-4">
                                <h4>Appointments</h4>
                                <p>Book and manage patient appointments with doctors.</p>
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

