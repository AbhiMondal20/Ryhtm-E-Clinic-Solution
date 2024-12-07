<?php session_start();
ob_start();
include('db_conn.php'); 
?>
<!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="description"
            content="E-Clinic Solutions by Abhitechbot offers advanced healthcare software services, including patient management systems, online appointment bookings, diagnostic tools, and more to streamline medical operations efficiently.">
        <meta name="keywords"
            content="E-Clinic Solutions, Abhitechbot, Healthcare Software, Patient Management System, Online Appointment Booking, Diagnostic Software, Clinic Management, Healthcare IT, Medical Software, Digital Healthcare">
        <meta name="author" content="Abhitechbot">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="opd/images/favicon.ico" rel="icon">
        <title>Rhythm E-Clinic Solutions - Log in</title>
        <link href="opd/admin/css/vendors_css.css" rel="stylesheet">
        <link href="opd/admin/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <script src="opd/admin/js/sweetalert.min.js"></script>

    </head>

    <body class="bg-img hold-transition theme-primary" style="background-image:url(opd/images/auth-bg/bg.webp)">
        <div class="h-p100 container">
            <div class="row align-items-center h-p100 justify-content-md-center">
                <div class="col-12">
                    <div class="row g-0 justify-content-center">
                        <div class="col-12 col-lg-5 col-md-5">
                            <div class="bg-white rounded10 shadow-lg">
                                <div class="content-top-agile p-20 pb-0">
                                    <h2 class="text-primary">Let's Get Started</h2>
                                    <p class="mb-0">Sign in to continue to Rhythm E-Clinic Solutions.</p>
                                </div>
                                <div class="p-40">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <input class="bg-transparent form-control ps-15" name="username"
                                                    placeholder="Username" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <input class="bg-transparent form-control ps-15" name="password"
                                                    placeholder="Password" required type="password" id="password" />
                                                <!-- Add an eye icon for toggling password visibility -->
                                                <span class="input-group-text bg-transparent" style="cursor: pointer;"
                                                    onclick="togglePassword()">
                                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 text-center"><input class="btn btn-danger mt-10"
                                                    name="login" type="submit" value="LOG IN"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="opd/admin/js/vendors.min.js"></script>
        <script src="opd/admin/js/netCheck.js"></script>


    </body>

    </html>
    <?php

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT dUSERNAME, dPASSWORD, regmod FROM dba WHERE dUSERNAME = ?");
    if ($stmt === false) {
        die('MySQL Prepare Error: ' . $conn->error);
    }
    
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbUsername, $dbPassword, $regmod);
        $stmt->fetch();
        
        if ($password == $dbPassword) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;

            // Redirect based on user role
            switch ($regmod) {
                case 'administrator':
                    header("Location: main-dashboard");
                    exit();
                case 'opdreceptionist':
                    header("Location: opd/investigation");
                    exit();
                case 'radiologyreceptionist':
                    header("Location: radiology/investigation");
                    exit();
                case 'centre':
                    header("Location: diagnostic/investigation");
                    exit();
                default:
                    header("Location: error-page"); // Optional for unexpected roles
                    exit();
            }
        } else {
            // Set an error session message and redirect back to login
            $_SESSION['error'] = "Invalid password!";
            header("Location: index");
            exit();
        }
    } else {
        // Set an error session message and redirect back to login
        $_SESSION['error'] = "Invalid username!";
        header("Location: index");
        exit();
    }

    $stmt->close();
}

// Display session error message (optional)
if (isset($_SESSION['error'])) {
    echo '
    <script>
        swal("Error!", "' . $_SESSION['error'] . '", "error");
        
    </script>';
    unset($_SESSION['error']); 
}
?>

