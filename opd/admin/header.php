<?php
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../index';</script>";
}

date_default_timezone_set("asia/kolkata");

include ('../../function.php');
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

    <link rel="icon" href="../images/favicon.ico">
    <title>Rhythm E-Clinic Solutions </title>
    <link rel="stylesheet" href="css/vendors_css.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skin_color.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="js/sweetalert.min.js"></script>
</head>

</head>

<body class="hold-transition light-skin sidebar-mini theme-success fixed">
    <div class="wrapper">
        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">
                <!-- Logo -->
                <a href="index" class="logo">
                    <!-- logo-->
                    <div class="logo-mini w-50">
                        <span class="light-logo"><img src="../images/logo-letter.png" alt="logo"></span>
                        <span class="dark-logo"><img src="../images/logo-letter.png" alt="logo"></span>
                    </div>
                    <div class="logo-lg">
                        <span class="light-logo"><img src="../images/logo-dark-text.png" alt="logo"></span>
                        <span class="dark-logo"><img src="../images/logo-light-text.png" alt="logo"></span>
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
                                            <?php echo $login_username; ?>
                                        </p>
                                    </div>
                                    <img src="../images/avatar/avatar-1.png"
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

        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar position-relative">
                <div class="multinav">
                    <div class="multinav-scroll" style="height: 100%;">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree">
                            <li>
                                <a href="index">
                                <i class="fa-solid fa-desktop"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa-solid fa-server"></i>
                                    <span>Master</span>
                                    <span class="pull-right-container">
                                    <i class="fa-solid fa-angle-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="dept-master">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Department Master
                                        </a>
                                    </li>
                                    <li>
                                        <a href="doctor-master">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Doctor Master
                                        </a>
                                    </li>
                                    <li>
                                        <a href="category-master">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Category Master
                                        </a>
                                    </li>
                                    <li>
                                        <a href="test-master">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Test Master
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="payment-mode">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Payment Mode
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="reg-list">
                                    <i class="fa-solid fa-hospital-user"></i>
                                    <span>Patient List</span>
                                </a>
                            </li>
                            <li>
                                <a href="reg">
                                <i class="fa-solid fa-file-circle-plus"></i>
                                    <span>New Registration</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                <i class="fa-solid fa-file-invoice"></i>
                                    <span>Billing</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="opd-billing2">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>
                                            <span>OPD Billing</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="due-payment">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>
                                            <span>Due Payment</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="return-billing">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>
                                            <span>Return Billing</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="money-receipt-list">
                                <i class="fa-solid fa-receipt"></i>
                                    <span>Money Receipt</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                <i class="fa-solid fa-folder"></i>
                                    <span>Reports</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="radiology-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Radiology Reports
                                        </a>
                                        <a href="pathology-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Pathology Reports
                                        </a>
                                    </li>
                                </ul>
                            </li>
                           
                            
                            <li class="treeview">
                                <a href="#">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                    <span>Billing Reports</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-right pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="user-wise-bill-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>User Wise Bill Report
                                        </a>
                                        <a href="total-cash-bill-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Total Cash Bill Reports
                                        </a>
                                        <a href="daily-cash-bill-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Daily Cash Bill Report
                                        </a>
                                        <a href="return-bill-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Return Bill
                                        </a>
                                        <a href="due-bill-report">
                                            <i class="fa-solid fa-code-commit"></i><span
                                                    class="path2"></span></i>Due Bill
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="online-patient" id="online-patient-link">
                                <i class="fa-solid fa-calendar-days"></i>
                                    <span>Online Booking</span>
                                </a>
                            </li>
                           
                           
                            <li>
                                <a href="dr-share-calculate">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    <span>Doctor Share Calculate</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </aside>