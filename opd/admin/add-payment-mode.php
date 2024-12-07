<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../index';</script>";
}
include ('header.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="fa-solid fa-house"></i></a></li>
                                
                                <li class="breadcrumb-item" aria-current="page">Payment</li>
                                <li class="breadcrumb-item active" aria-current="page">Mode</li>
                                <li class="breadcrumb-item active" ><a class="btn btn-sm btn-info text-white" onclick="goBack()"><i class="fa-solid fa-backward"></i> Back</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Basic Forms -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form novalidate method="POST">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h5>Payment Mode<span class="text-danger">*</span></h5>
                                            <input type="text" name="pMode" placeholder="" class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="save">SAVE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->

        <!-- upload CSV -->
        <section class="content">
            <!-- Basic Forms -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form novalidate method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <h5>Department (Upload CSV File)<span
                                                    class="text-danger">*</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="load/get_pMode_CSV_file.php" Download>
                                                    <i class="fa-solid fa-download"></i> Download Format</a>
                                            </h5>
                                            <input type="file" name="pMode" placeholder="Upload CSV File"
                                                class="form-control" required
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="uploadCSV">SAVE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box -->
        </section>
    </div>
</div>
<!-- /.content-wrapper -->


<?php
    if (isset($_POST['save'])) {
        $pMode = $_POST['pMode'];
        $addedBy = $login_username;
        $check_sql = "SELECT COUNT(*) AS count FROM paymentmode WHERE pMode = '$pMode'";
        $check_stmt = mysqli_query($conn, $check_sql);
        if ($check_stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $row = mysqli_fetch_array($check_stmt);
        $pMode_count = $row['count'];
        if ($pMode_count > 0) {

            echo '<script>
                    swal("Alert", "Payment Mode already exists!", "warning");
                </script>';
        } else {

            $sql = "INSERT INTO paymentmode (pMode, addedBy) VALUES ('$pMode', '$addedBy')";
            $stmt = mysqli_query($conn, $sql);
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                echo '<script>
                        swal("Success!", "", "success");
                        window.location.href="payment-mode";
                    </script>';
            }
        }
    }

    // CSV Upload 
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uploadCSV"])) {
        if (isset($_FILES["pMode"]) && $_FILES["pMode"]["error"] == UPLOAD_ERR_OK) {
            $csvFile = $_FILES["pMode"]["tmp_name"];
            $fileHandle = fopen($csvFile, "r");
            fgetcsv($fileHandle); 
            
            // Prepare SQL statements for insertion and update
            $sql_insert = "INSERT INTO paymentmode (pMode, addedBy) VALUES (?, ?)";
            $sql_update = "UPDATE paymentmode SET addedBy = ? WHERE pMode = ?";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_update = $conn->prepare($sql_update);
            $addedBy = $login_username;
            
            while (($data = fgetcsv($fileHandle, 1000, ",")) !== false) {
                $pMode = $data[0];
                
                // Check if department already exists in the database
                $check_sql = "SELECT pMode FROM paymentmode WHERE pMode = ?";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bind_param("s", $pMode);
                $check_stmt->execute();
                $check_stmt->store_result();
                
                if ($check_stmt->num_rows > 0) {
                    // Department exists, update it
                    $stmt_update->bind_param("ss", $addedBy, $pMode);
                    if (!$stmt_update->execute()) {
                        echo "Error updating department: " . $stmt_update->error;
                        exit;
                    }
                } else {
                    // Department does not exist, insert it
                    $stmt_insert->bind_param("ss", $pMode, $addedBy);
                    if (!$stmt_insert->execute()) {
                        echo "Error inserting department: " . $stmt_insert->error;
                        exit;
                    }
                }
                $check_stmt->close();
            }
            
            fclose($fileHandle);
            $conn->close();
            echo '<script>
                    swal("Success!", "", "success");
                  </script>';
        } else {
            echo '<script>
                    swal("No file uploaded.!", "", "error");
                  </script>';
        }
    }
    

    include ('footer.php');
?>