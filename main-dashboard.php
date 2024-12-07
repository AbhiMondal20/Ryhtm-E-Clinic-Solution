<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $username = $_SESSION['username'];
} else {
    echo "<script>location.href='/';</script>";
}
include('db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="E-Clinic Solutions by Abhitechbot offers advanced healthcare software services, including patient management systems, online appointment bookings, diagnostic tools, and more to streamline medical operations efficiently.">
    <meta name="keywords"
        content="E-Clinic Solutions, Abhitechbot, Healthcare Software, Patient Management System, Online Appointment Booking, Diagnostic Software, Clinic Management, Healthcare IT, Medical Software, Digital Healthcare">
    <meta name="author" content="Abhitechbot">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="opd/images/favicon.ico">
    <title>Rhythm E-Clinic Solutions</title>
    <!-- Vendors Style-->
    <link rel="stylesheet" href="opd/admin/css/vendors_css.css">
    <!-- Style-->
    <link rel="stylesheet" href="opd/admin/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

</head>

<body class="hold-transition light-skin sidebar-mini theme-success fixed">
    <div class="wrapper">
        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">
                <!-- Logo -->
                <a href="index" class="logo">
                    <!-- logo-->
                    <div class="logo-mini w-50">
                        <span class="light-logo"><img src="opd/images/logo-letter.png" alt="logo"></span>
                        <span class="dark-logo"><img src="opd/images/logo-letter.png" alt="logo"></span>
                    </div>
                    <div class="logo-lg">
                        <span class="light-logo"><img src="opd/images/logo-dark-text.png" alt="logo"></span>
                        <span class="dark-logo"><img src="opd/images/logo-light-text.png" alt="logo"></span>
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="btn-group nav-item">
                            <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light"
                                data-toggle="push-menu" role="button">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <!-- User Account-->
                        <li class="dropdown user user-menu">
                            <a href="#"
                                class="waves-effect waves-light dropdown-toggle w-auto l-h-12 bg-transparent py-0 no-shadow"
                                data-bs-toggle="dropdown" title="User">
                                <div class="d-flex pt-5">
                                    <div class="text-end me-10">
                                        <p class="pt-5 fs-14 mb-0 fw-700 text-primary"
                                            style="text-transform: capitalize;">
                                            <?php echo $username; ?>
                                        </p>
                                    </div>
                                    <img src="opd/images/avatar/avatar-1.png"
                                        class="avatar rounded-10 bg-primary-light h-40 w-40" alt="" />
                                </div>
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i>
                                        Profile</a>
                                    <a class="dropdown-item" href="#"><i class="fa-solid fa-gear"></i>
                                        Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="logout"><i class="fa-solid fa-lock"></i>
                                        Logout</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- OPD -->
                        <div class="col-xl-2 col-md-6 col-6">
                            <a href="opd/admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center">
                                            <h1 class="fs-50 text-primary"><i class="fa-solid fa-hospital"></i></h1>
                                            <span class="badge badge-pill badge-primary px-10 mb-10">OPD</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <a href="radiology/admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center">
                                            <h1 class="fs-50 text-primary"><i class="fa-solid fa-hospital"></i></h1>
                                            <span class="badge badge-pill badge-primary px-10 mb-10">Radiology</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-2 col-md-6 col-6">
                            <a href="diagnostic/admin">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="text-center">
                                            <h1 class="fs-50 text-primary"><i class="fa-solid fa-hospital"></i></h1>
                                            <span class="badge badge-pill badge-primary px-10 mb-10">Diagnostic</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
            </div>
        </div>
    </div>
</body>
<footer class="main-footer">
    Powered by &copy; <a href="https://abhitechbot.in" target="_BLANK">AbhiTechBot</a>
    <script>document.write(new Date().getFullYear())</script> <a href="https://abhitechbot.in" target="_BLANK">Rhythm
        E-Clinic Solutions</a>. Dec 24 Version
</footer>
<script src="opd/admin/js/netCheck.js"></script>
<script src="opd/admin/js/vendors.min.js"></script>

</body>

</html>