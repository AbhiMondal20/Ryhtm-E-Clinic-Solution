<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include 'header.php';

if ( isset($_GET['srno']) && isset($_GET['code'])) {
    $srno = $_GET['srno'];
    $code = $_GET['code'];
    
    $sql = "SELECT srno, centre, dept, modality, servname, servrate, ServFlag, cateVal, cate
            FROM servmaster
            WHERE code = ? AND srno = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die('MySQLi prepare error: ' . mysqli_error($conn));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ss', $code, $srno);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $srno, $selected_centre, $dept, $modality, $servname, $servrate, $ServFlag, $cateVal, $cate);

        // Initialize an empty array for cateVal
        $cateValArray = array();

        // Fetch values
        while (mysqli_stmt_fetch($stmt)) {
            // Process fetched data
            $servrate = number_format($servrate, 2);

            // Collect cateVal into an array
            $cateValArray[] = array(
                'cate' => $cate,
                'value' => $cateVal,
            );

            // Example of using fetched values
            $updatedept = $dept;
            $cateServ = $cate;
            // Do further processing here if needed
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle execution error
        die('MySQLi execute error: ' . mysqli_error($conn));
    }
} else {
    die('No code parameter found in GET request');
}

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
                                <li class="breadcrumb-item" aria-current="page">Test</li>
                                <li class="breadcrumb-item active" aria-current="page">Master</li>
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
                    <form novalidate method="POST" enctype="multipart/form-data">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Code</h5>
                                        <div class="controls">
                                            <input type="text" name="code" placeholder="000001" class="form-control"
                                                required value="<?php echo $code; ?>" readonly
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Department<span class="text-danger">*</span></h5>
                                        <input list="deptlist" name="dept" class="form-control"
                                            value="<?php echo $dept; ?>">
                                        <datalist id="deptlist">
                                            <?php
                                            $sql = "SELECT dept FROM deptmaster";
                                            $stmt = mysqli_query($conn, $sql);
                                            if ($stmt === false) {
                                                die(print_r(mysqli_errors(), true));
                                            } else {
                                                while ($row = mysqli_fetch_array($stmt)) {
                                                    $dept = $row['dept'];
                                                    echo '<option value="' . $dept . '">' . $dept . '</option>';
                                                }
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Centre<span class="text-danger">*</span></h5>
                                            <input list="centrelist" name="centre" value="<?php echo $selected_centre; ?>" class="form-control" required>
                                            <datalist id="centrelist">
                                                <?php
                                                    $sql = "SELECT uname FROM dba WHERE regmod ='centre'";
                                                    $stmt = mysqli_query($conn, $sql);

                                                    // Error handling
                                                    if ($stmt === false) {
                                                        die("Query failed: " . mysqli_error($conn));
                                                    } else {
                                                        // Fetch and display departments in the datalist
                                                        while ($row = mysqli_fetch_assoc($stmt)) {
                                                            $uname = htmlspecialchars($row['uname']);
                                                            // Check if the current uname matches the selected value
                                                            $selected = ($uname == $selected_centre) ? 'selected' : '';
                                                            echo '<option value="' . $uname . '" ' . $selected . '>' . $uname . '</option>';
                                                        }
                                                    }
                                                ?>
                                            </datalist>
                                        </div>

                                    </div>
                                    
                                    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Modality</h5>
                                        <input type="text" name="modality" class="form-control"
                                            value="<?php echo $modality; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>Test Name<span class="text-danger">*</span></h5>
                                        <input type="text" name="servname" placeholder="" class="form-control"
                                            value="<?php echo $servname; ?>" required
                                            data-validation-required-message="This field is required">
                                    </div>
                                </div>
                                <div class="col-md-3" style="display:none;">
                                    <div class="form-group">
                                        <h5>Price</h5>
                                        <input type="text" name="servrate0" placeholder="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5>status<span class="text-danger">*</span></h5>
                                        <select name="ServFlag" class="form-control" required>
                                            <option value="Y">Active</option>
                                            <option value="N">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-4">
                                    <hr>
                                    <h2>CATEGORY:</h2>
                                    <?php
                                    $sno = 0;
                                    $sql = "SELECT id, cate FROM catemaster";
                                    $stmt = mysqli_query($conn, $sql);
                                    if ($stmt === false) {
                                        die('MySQL error: ' . mysqli_error($conn));
                                    }
                                    while ($row = mysqli_fetch_array($stmt)) {
                                        $sno++;
                                        $id = $row['id'];
                                        $cate = $row['cate'];
                                        $value = '';
                                        foreach ($cateValArray as $item) {
                                            if ($item['cate'] === $cate) {
                                                $value = $item['value'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <div class="form-group row">
                                            <label class="col-form-label col-md-2"><?php echo $sno; ?>.</label>
                                            <label class="col-form-label col-md-2"><?php echo $cate; ?></label>
                                            <input class="form-control col-md-2" type="hidden" name="cate[]"
                                                value="<?php echo $cate; ?>">
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="cateVal[]"
                                                    value="<?php echo $value; ?>">
                                            </div>
                                        </div>
                                        <?php
                                    } ?>
                                </div>

                            </div>
                        </div>
                </div>
                <center>
                    <div class="text-xs-right">
                        <button type="submit" class="btn btn-info m-4" name="save">SAVE</button>
                    </div>
                </center>
                </form>
            </div>
            <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->

</section>
<!-- /.content -->
</div>
</div>
<!-- /.content-wrapper -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $success = true;

    // Loop through category values
    foreach ($_POST['cateVal'] as $i => $cateVal) {
        if (!empty($cateVal)) {
            // Retrieve form values for the current row
            $dept = $_POST['dept'] ?? null;
            $code = $_POST['code'] ?? null;
            $centre = $_POST['centre'] ?? null;
            $cate = $_POST['cate'][$i] ?? null;
            $servname = $_POST['servname'] ?? null;
            $modality = $_POST['modality'] ?? null;
            $ServFlag = $_POST['ServFlag'] ?? null;

            // Validate mandatory fields
            if (empty($dept) || empty($code) || empty($centre) || empty($cate)) {
                echo "Missing required fields for row $i. Skipping.<br>";
                continue;
            }

            // SQL Query for update
            $sql = "UPDATE servmaster 
                    SET modality = ?, dept = ?, servname = ?, ServFlag = ?, cate = ?, cateVal = ?, centre = ?
                    WHERE code = ?";

            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                $success = false;
                echo "Error preparing statement: " . mysqli_error($conn);
                break;
            }

            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'ssssssss', $modality,  $dept, $servname, $ServFlag, $cate, $cateVal, $centre, $code);

            // Execute query
            if (!mysqli_stmt_execute($stmt)) {
                $success = false;
                echo "Error executing query: " . mysqli_stmt_error($stmt);
                break;
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Skipping row $i due to empty category value.<br>";
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Display success or error message
    if ($success) {
        echo '<script>
                swal("Success!", "Records updated successfully", "success");
                setTimeout(function(){
                    window.location.href = "test-master";
                }, 2000);
              </script>';
    } else {
        echo '<script>
                swal("Error!", "An error occurred while updating records", "error");
              </script>';
    }
}


include 'footer.php';
?>