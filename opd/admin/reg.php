<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

?>
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/"><i class="fa-solid fa-house"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Registration </li>
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
                        <form novalidate method="POST" action="">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="controls">
                                            <h5>MR. No. <span class="text-danger">*</span></h5>
                                            <?php
                                            $sql = "SELECT rno FROM registration ORDER BY id DESC";
                                            $stmt = mysqli_query($conn, $sql);
                                            if ($stmt === false) {
                                                die(print_r(mysqli_errors(), true));
                                            } else {
                                                $next_rno = "MR000001";
                                                if (mysqli_num_rows($stmt)) {
                                                    $row = mysqli_fetch_array($stmt);
                                                    $last_rno = $row['rno'];
                                                    if (!empty($last_rno)) {
                                                        $last_number = intval(substr($last_rno, 2));
                                                        $next_number = $last_number + 1;
                                                        $next_rno = "MR" . str_pad($next_number, 6, "0", STR_PAD_LEFT); // Format next rno
                                                    }
                                                }
                                            }
                                            ?>
                                            <!-- <form action="reg.php" method="GET"> -->
                                            <div class="input-group">
                                                <input type="search" class="form-control" name="rno" readonly
                                                    placeholder="MR000001" class="form-control" required
                                                    value="<?php echo $next_rno; ?>"
                                                    data-validation-required-message="This field is required"
                                                    aria-label="Search">
                                            </div>
                                            <!-- </form> -->
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>OP No.</h5>
                                            <div class="controls">
                                                <?php
                                                $sql = "SELECT opid FROM registration ORDER BY id DESC";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    $next_opid = "000001";
                                                    if (mysqli_num_rows($stmt)) {
                                                        $row = mysqli_fetch_array($stmt);
                                                        $last_opid = $row['opid'];
                                                        if (!empty($last_opid)) {
                                                            $last_number = intval(substr($last_opid, 2));
                                                            $next_number = $last_number + 1;
                                                            $next_opid = "OP" . str_pad($next_number, 6, "0", STR_PAD_LEFT);
                                                        }
                                                    }
                                                }
                                                ?>
                                                <input type="text" name="opid" placeholder="OP000001"
                                                    class="form-control" required value="<?php echo $next_opid; ?>"
                                                    readonly data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5> <span class="text-danger">*</span></h5>
                                                <input type="text" name="se" class="form-control"
                                                    placeholder="2024-2025" required value="2024-2025" readonly
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Reg. Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" class="form-control" required name="rdate"
                                                    value="<?php echo date('Y-m-d'); ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Salutation <span class="text-danger">*</span></h5>
                                            <select class="form-select select2" name="rtitle">
                                                <?php
                                                $sql = "SELECT title FROM titlemaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt)) {
                                                        $title = $row['title'];
                                                        echo '<option value="' . $title . '">' . $title . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>First Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rfname"
                                                    tabindex="1"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Middle Name</h5>
                                                <input type="text" class="form-control" name="rmname">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Last Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rlname"
                                                    tabindex="2"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Gender <span class="text-danger">*</span></h5>
                                            <select class="form-select" name="rsex" tabindex="3">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Age (Years) <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="rage"
                                                    tabindex="4"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Ph. No. <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" required name="phone"
                                                    tabindex="5" id="phoneInput" maxlength="10" minlength="10"
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
                                                    tabindex="7"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Department</h5>
                                            <input list="deptlist" name="dept" id="dept" tabindex="9"
                                                onchange="getDeptDoctors(this.value, true)" class="form-control">
                                            <datalist id="deptlist">
                                                <option selected disabled>Select Department</option>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Ref. Source </h5>
                                            
                                            <select class="form-select select2" name="rdocname">
                                                <?php
                                                $sql = "SELECT docName FROM docmaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_errors(), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt)) {
                                                        $docName = $row['docName'];
                                                        echo '<option value="' . $docName . '">' . $docName . '</option>';
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
                            <center>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="save" tabindex="13">SAVE</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
</section>
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

    // doctor fetch by Department
    var deptSelected = false;
    var doctorSelected = false;

    function getDeptDoctors(dept, fromDeptSelect) {
        deptSelected = fromDeptSelect;
        $.ajax({
            url: "load/doc_fetch_by_dept.php",
            type: "POST",
            data: { dept: dept },
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    console.error(data.error);
                } else {
                    var dataList = $('#doctlist');
                    dataList.empty();
                    dataList.append('<option selected disabled>Select Doctor</option>');
                    $.each(data, function (index, doctor) {
                        dataList.append($('<option>', {
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

    function getDocname(docName, fromDocSelect) {
        doctorSelected = fromDocSelect;
        if (!docName) {
            $("#wamt").val('');
            return;
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

    $(document).ready(function () {
        $('#dept').change(function () {
            if (!doctorSelected) {
                $('#wamt').val('');
            }
            doctorSelected = false;
            if (!deptSelected) {
                getDeptDoctors($(this).val(), true);
            }
            deptSelected = false;
        });

        $('#rdoc').change(function () {
            if (!deptSelected) {
                $('#wamt').val('');
            }
            deptSelected = false;
            if (!doctorSelected) {
                getDocname($(this).val(), true);
            }
            doctorSelected = false;
        });
    });

    // Mobile number check
    function checkPhoneNumber() {
        var phoneNumber = document.getElementById('phoneInput').value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "exists") {
                    swal({
                        title: 'Phone number already registered!',
                        text: 'Please enter a different phone number.',
                        icon: 'warning',
                        button: 'OK',
                    });
                    document.getElementById('phoneInput').value = '';
                }
            }
        };
        xhttp.open("GET", "load/checkPhoneNumber.php?phoneNumber=" + phoneNumber, true);
        xhttp.send();
    }
</script>

<?php
if (isset($_POST['save'])) {
    $rno = $_POST['rno'];
    $opid = $_POST['opid'];
    $se = $_POST['se'];
    $rdate = $_POST['rdate'];
    $rtime = date('H:i:s A');
  
    $rtitle = $_POST['rtitle'];
    $rfname = $_POST['rfname'];
    $rmname = $_POST['rmname'];
    $rlname = $_POST['rlname'];
    $rsex = $_POST['rsex'];
    $rage = $_POST['rage'];
 
    $radd1 = $_POST['radd1'];
    $phone = $_POST['phone'];
    $rdocname = $_POST['rdocname'];
   
    $dept = $_POST['dept'];
   
    $addedBy = $_POST['addedBy'];

    $sql = "INSERT INTO registration (rno, opid, se, rdate, rtime, rtitle, rfname, rmname, addedBy, rlname, rsex, rage, radd1, phone, dept, rdocname) 
    VALUES ('$rno', '$opid', '$se', '$rdate', '$rtime', '$rtitle', '$rfname', '$rmname', '$addedBy', '$rlname', '$rsex', '$rage', '$radd1', '$phone', '$dept', '$rdocname')";
    $stmt = mysqli_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(mysqli_errors(), true));
    } else {
        
        if ($stmt->execute()) {
           
              echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href="opd-billing2?id='.$id.'&rno='. $rno.'";
                    }, 1000);
              </script>';
              
        } 
        
    }
}

include ('footer.php');

        ?>