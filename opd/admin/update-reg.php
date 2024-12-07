<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}

include ('header.php');

$regid = $_GET['id'];
$rno = $_GET['rno'];

$sql = "SELECT r.rno, r.opid, r.se, r.rdate, r.rtime, r.rfname, r.rmname,r.rlname, r.rsex, r.rage, r.radd1, r.phone, r.dept, r.rdocname
FROM registration AS r
WHERE r.rno = '$rno' AND r.id = '$regid'";

$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $rno = $row['rno'];
    $opid = $row['opid'];
    $se = $row['se'];
    $rdate = $row['rdate'];
    $rtime = $row['rtime'];
    $rfname = $row['rfname'];
    $rmname = $row['rmname'];
    $rlname = $row['rlname'];
    $rsex = $row['rsex'];
    $rage = $row['rage'];
    $radd1 = $row['radd1'];
    $phone = $row['phone'];
    $selectedDocName = $row['rdocname'];
    $selectedDept = $row['dept'];
}


?>
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
                                <li class="breadcrumb-item" aria-current="page">OPD List</li>
                                <li class="breadcrumb-item active" aria-current="page">Registration</li>
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
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="controls">
                                            <h5>MR. No. <span class="text-danger">*</span></h5>
                                            <input type="text" name="rno" placeholder="MR000001" class="form-control"
                                                required value="<?php echo $rno; ?>" readonly
                                                data-validation-required-message="This field is required">
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>OP No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="opid" placeholder="OP000001"
                                                    class="form-control" required value="<?php echo $opid; ?>" readonly
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5> <span class="text-danger">*</span></h5>
                                                <input type="text" name="se" class="form-control"
                                                    placeholder="2024-2025" required value="<?php echo $se; ?>" readonly
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $se; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Reg. Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" class="form-control" required name="rdate"
                                                    value="<?php echo $rdate; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>First Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rfname"
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $rfname; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Middle Name</h5>
                                                <input type="text" class="form-control" name="rmname"
                                                    value="<?php echo $rmname; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Last Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rlname"
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $rlname; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Gender <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rsex">
                                                <option value="Male" <?php if ($rsex == 'Male')
                                                    echo ' selected'; ?>>Male
                                                </option>
                                                <option value="Female" <?php if ($rsex == 'Female')
                                                    echo ' selected'; ?>>
                                                    Female</option>
                                                <option value="Others" <?php if ($rsex == 'Others')
                                                    echo ' selected'; ?>>
                                                    Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Age (Years) <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rage"
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $rage; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="phone"
                                                    id="phoneInput" maxlength="10" minlength="10"
                                                    value="<?php echo $phone; ?>"
                                                    data-validation-required-message="This field is required"
                                                    onblur="checkPhoneNumber()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Address <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="radd1"
                                                    value="<?php echo $radd1; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Department <span class="text-danger">*</span></h5>
                                        <select class="form-select select2" name="dept" tabindex="9">
                                            <?php
                                            $sql = "SELECT dept FROM deptmaster";
                                            $stmt = mysqli_query($conn, $sql);
                                            if ($stmt === false) {
                                                die("Error: " . mysqli_error($conn));
                                            } else {
                                                while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                    $dept = $row['dept'];
                                                    echo '<option value="' . htmlspecialchars($dept) . '"';
                                                    if ($dept == $selectedDept) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . htmlspecialchars($dept) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Ref. Source <span class="text-danger">*</span></h5>
                                            
                                            <select class="form-select select2" name="rdocname" tabindex="10">
                                            <?php
                                            $sql = "SELECT docName FROM docmaster";
                                            $stmt = mysqli_query($conn, $sql);
                                            if ($stmt === false) {
                                                die("Error: " . mysqli_error($conn));
                                            } else {
                                                while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                    $docName = $row['docName'];
                                                    echo '<option value="' . htmlspecialchars($docName) . '"';
                                                    if ($docName == $selectedDocName) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . htmlspecialchars($docName) . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="addedBy"
                                        value="<?php echo $login_username; ?>">
                                </div>
                        </div>
                                </div>
                                <center>
                                    <div class="text-xs-right">
                                        <button type="submit" class="btn btn-info" name="save">SAVE</button>
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

<script>
    // City to dist Dependency
    $(document).ready(function () {
        $('#rcity').change(function () {
            var selectedCity = $(this).val();
            getDistrictStateCountry(selectedCity);
        });

        function getDistrictStateCountry(rcity) {
            $.ajax({
                url: "load/get_dist.php",
                type: "POST",
                data: { rcity: rcity },
                dataType: "json",
                success: function (data) {
                    $("#rdist").val(data.distname);
                    $("#rstate").val(data.state);
                    $("#rcountry").val(data.country);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });


    // Function to populate doctors based on selected department
    function getDeptDoctors(dept) {
        $.ajax({
            url: "load/doc_fetch_by_dept.php",
            type: "POST",
            data: { dept: dept },
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                } else {
                    $('#rdoc').empty().append('<option value="">-- Select Doctor --</option>');
                    $.each(data, function (index, doctor) {
                        $('#rdoc').append($('<option>', {
                            value: doctor.docName,
                            text: doctor.docName
                        }));
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }


    // clear fee when change doctor or department
    $(document).ready(function () {
        // Add event listener for department select box
        $('#dept').change(function () {
            // Clear fee input field when department changes
            $('#wamt').val('');
        });

        // Add event listener for doctor select box
        $('#rdoc').change(function () {
            // Clear fee input field when doctor changes
            $('#wamt').val('');
        });
    });

    // Function to fetch fee for the selected doctor
    function getDocname(docName) {
        if (!docName) {
            // If no doctor is selected, clear the fee input field
            $("#wamt").val('');
            return; // Exit the function early
        }

        $.ajax({
            url: "load/doc_fetch_price.php",
            type: "POST",
            data: { docName: docName },
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                } else {
                    $("#wamt").val(data.fee);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

</script>

<?php

if (isset($_POST['save'])) {
    $rno = $_POST['rno'];
    $opid = $_POST['opid'];
    $se = $_POST['se'];
    $rdate = $_POST['rdate'];
    $rtime = date('H:i:s'); 
    $rfname = $_POST['rfname'];
    $rmname = $_POST['rmname'];
    $rlname = $_POST['rlname'];
    $rsex = $_POST['rsex'];
    $rage = $_POST['rage'];
    $phone = $_POST['phone'];
    $rdocname = $_POST['rdocname'];
    $radd1 = $_POST['radd1'];
    $dept = $_POST['dept'];
    $modify_date = date('Y-m-d H:i:s');
   
    $sql = "UPDATE registration SET 
                se = ?, 
                rdate = ?, 
                rtime = ?, 
                rfname = ?, 
                rmname = ?, 
                rlname = ?, 
                rsex = ?, 
                rage = ?, 
                radd1 = ?, 
                phone = ?, 
                rdocname = ?, 
                modifiedBy = ?, 
                modifiedDate = ?
            WHERE rno = ? AND id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'ssssssssssssssi', $se, $rdate, $rtime, $rfname, $rmname, $rlname, $rsex, $rage, $radd1, $phone, $rdocname, $login_username, $modify_date, $rno, $regid);

    if (mysqli_stmt_execute($stmt)) {
    
    $sql = "UPDATE `billingdetails` SET `rdocname`='$rdocname' WHERE rno='$rno' AND opid = '$opid'";
    $res = mysqli_query($conn, $sql);
    if($res){
                echo '<script>
                swal("Success!", "", "success");
                setTimeout(function(){
                    window.location.href = "reg-list";
                }, 1000);
            </script>';
    }
    } else {
        echo '<script>
                swal("Error!", "Please contact the support team.", "error");
                setTimeout(function(){
                    window.location.href = window.location.href;
                }, 2000);
              </script>';
    }

    mysqli_stmt_close($stmt);
}



include ('footer.php');

?>