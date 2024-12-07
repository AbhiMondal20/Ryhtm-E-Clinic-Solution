<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');

$id = $_GET['id'];
$rno = $_GET['rno'];

$sql = "SELECT r.rno, r.opid, r.se, r.rtitle, r.rdate, r.rtime, r.rfname, r.rmname,r.rlname, r.rsex, r.rage, r.radd1, r.phone, r.dept, r.rdocname, r.rdoc, r.wamt, r.RegCharges, r.discount, r.discountAmt, r.billAmount, r.paymentType
FROM registration AS r
WHERE r.rno = '$rno' AND r.id = '$id'";

$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $rno = $row['rno'];
    $opid = $row['opid'];
    
    $se = $row['se'];
    $rtitle = $row['rtitle'];
    $rtime = $row['rtime'];
    $rfname = $row['rfname'];
    $rmname = $row['rmname'];
    $rlname = $row['rlname'];
    $rsex = $row['rsex'];
    $rage = $row['rage'];
    $radd1 = $row['radd1'];
    $phone = $row['phone'];
    $wamt = $row['wamt'];
    $selectedDocName = $row['rdocname'];
    $selectedrefDoc = $row['rdoc'];
    $selectedDept = $row['dept'];
    $RegCharges = $row['RegCharges'];
    $discount = $row['discount'];
    $discountAmt = $row['discountAmt'];
    $billAmount = $row['billAmount'];
    $selectedPaymentType = $row['paymentType'];

    $rdate = new DateTime($row['rdate']);
    $formattedRdate = $rdate->format('Y-m-d');
    $revisitDate = date('Y-m-d');
    
    $actualFee = $wamt; 
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

                                <li class="breadcrumb-item" aria-current="page">OPD</li>
                                <li class="breadcrumb-item active" aria-current="page">Revisit </li>
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
                                    <div class="col-md-2">
                                        <div class="controls">
                                            <h5>MR. No. <span class="text-danger">*</span></h5>
                                            <input type="text" name="rno" placeholder="MR000001" class="form-control"
                                                required value="<?php echo $rno; ?>" readonly
                                                data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>OP No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="opid" placeholder="OP000001"
                                                    class="form-control" required value="<?php echo $opid; ?>"
                                                    readonly data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5> <span class="text-danger">*</span></h5>
                                                <input type="text" name="se" class="form-control"
                                                    placeholder="2024-2025" required value="2024-2025" readonly
                                                    data-validation-required-message="This field is required"
                                                    value="<?php echo $se; ?>">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Reg. Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" readonly class="form-control" required name="rdate" data-validation-required-message="This field is required" value="<?php echo $formattedRdate; ?>">
                                            </div>
                                        </div>
                                    </div>
                                   <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Revisit Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="date" class="form-control" required name="revisitDate"
                                                       data-validation-required-message="This field is required"
                                                       min="<?php echo date('Y-m-d'); ?>" oninput="handleInputChange()">
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
                                                    while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                        $title = $row['title'];
                                                        echo '<option value="' . $title . '"';
                                                        if ($title == $rtitle) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . $title . '</option>';
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
                                                    value="<?php echo $phone; ?>" required
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
                                                    value="<?php echo $radd1; ?>" required
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Department <span class="text-danger">*</span></h5>
                                       <input list="deptlist" name="dept" id="dept" tabindex="9"
                                               onchange="getDeptDoctors(this.value, true)" class="form-control"
                                               value="<?php echo htmlspecialchars($selectedDept); ?>" />
                                        <datalist id="deptlist">
                                            <option disabled>Select Department</option>
                                            <?php
                                           
                                            $sql = "SELECT dept FROM deptmaster";
                                            if ($stmt = $conn->prepare($sql)) {
                                               
                                                $stmt->execute();
                                               
                                                $stmt->bind_result($dept);
                                               
                                                while ($stmt->fetch()) {
                                                    echo '<option value="' . htmlspecialchars($dept) . '"';
                                              
                                                    if ($dept === $selectedDept) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . htmlspecialchars($dept) . '</option>';
                                                }
                                             
                                                $stmt->close();
                                            } else {
                                               
                                                die('Error: ' . $conn->error);
                                            }
                                            ?>
                                        </datalist>


                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Consult Doctor <span class="text-danger">*</span></h5>
                                            <input list="doctlist" name="rdocname" id="rdoc" required tabindex="10"
                                                   onchange="getDocname(this.value, true)" class="form-control"
                                                   value="<?php echo htmlspecialchars($selectedDocName); ?>" />
                                            <datalist id="doctlist">
                                                <option disabled>Select Doctor</option>
                                                <?php
                                                $sql = "SELECT docName FROM docmaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt === false) {
                                                    die(print_r(mysqli_error($conn), true));
                                                } else {
                                                    while ($row = mysqli_fetch_array($stmt)) {
                                                        $docName = $row['docName'];
                                                        echo '<option value="' . htmlspecialchars($docName) . '"';
                                                        if ($docName === $selectedDocName) {
                                                            echo ' selected';
                                                        }
                                                        echo '>' . htmlspecialchars($docName) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>

                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Fee <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" name="wamt" id="wamt" required
                                                readonly value="<?php echo $wamt; ?>" oninput="handleInputChange2()"  data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Ref. Source </h5>
                                         <input list="rdocnamelist" name="rdoc" class="form-control" tabindex="11" value="<?php echo htmlspecialchars($selectedrefDoc); ?>">
                                        <datalist id="rdocnamelist">
                                            <option selected disabled>Select Doctor</option>
                                            <?php
                                            $sql = "SELECT docName FROM docmaster";
                                            $stmt = mysqli_query($conn, $sql);
                                            if ($stmt === false) {
                                                die(print_r(mysqli_error($conn), true));
                                            } else {
                                                while ($row = mysqli_fetch_array($stmt)) {
                                                    $docName = $row['docName'];
                                                    echo '<option value="' . htmlspecialchars($docName) . '"';
                                                    if ($docName === $selectedDocName) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . htmlspecialchars($docName) . '</option>';
                                                }
                                            }
                                            ?>
                                        </datalist>

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Discount</h5>
                                          <input type="text" class="form-control" placeholder="Discount %" tabindex="13"
                                                    name="discount" id="discount" required="" value="0.00" oninput="handleInputChange2()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Disc. Amount </h5>
                                          <input type="text" class="form-control" placeholder="Discount Amt." tabindex="14"
                                                    name="discountAmt" id="discountAmt" value="0.00" oninput="handleInputChange2()">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Net Amount <span class="text-danger">*</span></h5>
                                          <input type="text" class="form-control" placeholder="Bill Amount"
                                                    name="billAmount" id="billAmount" required data-validation-required-message="This field is required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h5>Payment Type<span class="text-danger">*</span></h5>
                                                <select class="form-select select2" name="paymentType" tabindex="15" required data-validation-required-message="This field is required">
                                                     <?php
                                                        $sql = "SELECT pMode, id FROM paymentmode";
                                                        $stmt = mysqli_query($conn, $sql);
                                                        if ($stmt === false) {
                                                            die(print_r(sqlsrv_errors(), true));
                                                        } else {
                                                            while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                                $pMode = $row['pMode'];
                                                                $id = $row['id'];
                                                                echo "<option value='$pMode'>$pMode</option>";
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
                            <button type="submit" class="btn btn-info" name="save" tabindex="13">SAVE</button>
                        </div>
                    </center>
                    </form>
                </div>
            </div>
    </div>
</div>
</section>
</div>
</div>
<!-- /.content-wrapper -->

<!-- Visit Revisit script -->
<script>
function handleInputChange() {
    // Ensure the date from PHP is properly formatted
    const rdateString = '<?php echo $formattedRdate; ?>';
    const rdate = new Date(rdateString);
    console.log("Rdate:", rdate);  // Debugging: Check the value of rdate

    // Ensure revisitDate is valid
    const revisitDateString = document.querySelector('[name="revisitDate"]').value;
    const revisitDate = new Date(revisitDateString);
    console.log("Revisit Date:", revisitDate);  // Debugging: Check the value of revisitDate

    const feeInput = document.getElementById('wamt');
    const actualFee = <?php echo $actualFee; ?>;
    console.log("Actual Fee:", actualFee);  // Debugging: Check the actual fee

    // If revisitDate is invalid, return early
    if (isNaN(revisitDate.getTime())) {
        console.error("Invalid revisit date");
        return;
    }

    // Calculate the difference in days between rdate and revisitDate
    const timeDifference = revisitDate.getTime() - rdate.getTime();
    const dayDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
    console.log("Day Difference:", dayDifference);  // Debugging: Check the day difference

    // Set fee based on the day difference
    if (dayDifference <= 7) {
        feeInput.value = 0;  // Fee is 0 if revisit is within 7 days
    } else {
        feeInput.value = actualFee;  // Otherwise, use actualFee
    }
}

// Attach event listener to the revisit date input field
document.querySelector('[name="revisitDate"]').addEventListener('input', handleInputChange);
</script>


<!--Discount-->
<script>
    // Function to calculate the discount from percentage
function calculateDiscountFromPercentage() {
    var fee = parseFloat(document.getElementById("wamt").value) || 0;
    var discount = parseFloat(document.getElementById("discount").value) || 0;

    // Calculate the discount amount from the percentage
    var discountAmt = (fee * discount) / 100;
    document.getElementById("discountAmt").value = discountAmt.toFixed(2);

    // Calculate the net amount after discount
    var netAmount = fee - discountAmt;
    document.getElementById("billAmount").value = netAmount.toFixed(2);
}

// Function to calculate the discount percentage from amount
function calculateDiscountFromAmount() {
    var fee = parseFloat(document.getElementById("wamt").value) || 0;
    var discountAmt = parseFloat(document.getElementById("discountAmt").value) || 0;

    // Calculate the discount percentage from the amount
    var discount = (discountAmt / fee) * 100;
    document.getElementById("discount").value = discount.toFixed(2);

    // Calculate the net amount after discount
    var netAmount = fee - discountAmt;
    document.getElementById("billAmount").value = netAmount.toFixed(2);
}

// Main input handler for calculating amounts dynamically
function handleInputChange2() {
    var fee = parseFloat(document.getElementById("wamt").value) || 0;

    // Automatically calculate the other discount field when one is updated
    var discountField = document.getElementById("discount");
    var discountAmtField = document.getElementById("discountAmt");

    discountField.addEventListener('input', function () {
        calculateDiscountFromPercentage();
    });

    discountAmtField.addEventListener('input', function () {
        calculateDiscountFromAmount();
    });

    // Calculate the net amount if no discount is applied
    var discountAmt = parseFloat(discountAmtField.value) || 0;
    var netAmount = fee - discountAmt;
    document.getElementById("billAmount").value = netAmount.toFixed(2);
}

// Set default billAmount to wamt on page load
function setInitialBillAmount() {
    var fee = parseFloat(document.getElementById("wamt").value) || 0;
    document.getElementById("billAmount").value = fee.toFixed(2);
}

// Call the function to set initial bill amount
setInitialBillAmount();

// Event listeners for discount input fields
document.getElementById("discount").addEventListener('input', handleInputChange2);
document.getElementById("discountAmt").addEventListener('input', handleInputChange2);

</script>


<!-- City Dist State Country Script -->
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

</script>
<!-- Dept Dr. List Script -->
<script>
    $(document).ready(function () {
        // Function to fetch doctors for the selected department
        $('#dept').change(function () {
            var dept = $(this).val();
            $.ajax({
                url: "load/doc_fetch_by_dept.php",
                type: "POST",
                data: { dept: dept },
                dataType: "json",
                success: function (data) {
                    $('#rdoc').empty().append('<option selected disabled>Select Doctor</option>');
                    $.each(data, function (index, doctor) {
                        $('#rdoc').append('<option value="' + doctor.docName + '">' + doctor.docName + '</option>');
                    });
                    $('#wamt').val('');
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Function to fetch fee for the selected doctor
        $('#rdoc').change(function () {
            var docName = $(this).val();
            if (!docName) {
                $('#wamt').val('');
                return;
            }
            $.ajax({
                url: "load/doc_fetch_price.php",
                type: "POST",
                data: { docName: docName },
                dataType: "json",
                success: function (data) {
                    $('#wamt').val(data.fee);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });


</script>

<!-- Dr Fee Script -->
<script>
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

    $rno = isset($_POST['rno']) ? $_POST['rno'] : '';
    $opid = isset($_POST['opid']) ? $_POST['opid'] : '';
    $rdate = isset($_POST['rdate']) ? $_POST['rdate'] : '';
    $revisitDate = isset($_POST['revisitDate']) ? $_POST['revisitDate'] : '';
    $rfname = isset($_POST['rfname']) ? $_POST['rfname'] : '';
    $rmname = isset($_POST['rmname']) ? $_POST['rmname'] : '';
    $rlname = isset($_POST['rlname']) ? $_POST['rlname'] : '';
    $rsex = isset($_POST['rsex']) ? $_POST['rsex'] : '';
    $rage = isset($_POST['rage']) ? $_POST['rage'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $radd1 = isset($_POST['radd1']) ? $_POST['radd1'] : '';
    $dept = isset($_POST['dept']) ? $_POST['dept'] : '';
    $rdocname = isset($_POST['rdocname']) ? $_POST['rdocname'] : '';
    $rdoc = isset($_POST['rdoc']) ? $_POST['rdoc'] : '';
    $wamt = isset($_POST['wamt']) ? $_POST['wamt'] : '';
    $discount = isset($_POST['discount']) ? $_POST['discount'] : '';
    $discountAmt = isset($_POST['discountAmt']) ? $_POST['discountAmt'] : '';
    $billAmount = isset($_POST['billAmount']) ? $_POST['billAmount'] : '';
    $paymentType = isset($_POST['paymentType']) ? $_POST['paymentType'] : '';
    $addedBy = isset($_POST['addedBy']) ? $_POST['addedBy'] : '';
    $visitType = 'revisit';

    // Correct prepared statement syntax
    $sql = "UPDATE registration SET visitType = ?, visitDate = ? WHERE rno = ? AND opid = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die('Prepare failed: ' . mysqli_error($conn));
    }

    // Bind parameters for the UPDATE statement
    mysqli_stmt_bind_param($stmt, 'ssss', $visitType, $revisitDate, $rno, $opid);

    // Execute the prepared statement
    if (!mysqli_stmt_execute($stmt)) {
        die('Execute failed: ' . mysqli_stmt_error($stmt));
    } else {
        // Insert into `revisit` table
        $sql = "INSERT INTO `revisit`(`rno`, `opid`, `rfname`, `rmname`, `rlname`, `rsex`, `rage`, `phone`, `radd1`, `dept`, `revisitDate`, `rdocname`, `rdoc`, `wamt`, `discount`, `discountAmt`, `billAmount`, `paymentType`, `addedBy`) 
                VALUES ('$rno', '$opid', '$rfname', '$rmname', '$rlname', '$rsex', '$rage', '$phone', '$radd1', '$dept', '$revisitDate', '$rdocname', '$rdoc', '$wamt', '$discount', '$discountAmt', '$billAmount', '$paymentType', '$addedBy')";

        $res = mysqli_query($conn, $sql);

        if ($res) {
            echo '<script>
                    swal("Success!", "", "success");
                    setTimeout(function(){
                        window.location.href="revisit-pdf3?opid=' . $opid . '&rno=' . $rno . '";
                    }, 1000);
                  </script>';
        } else {
            die('Insert failed: ' . mysqli_error($conn));
        }
    }

    // Free statement resources
    mysqli_stmt_close($stmt);
}


include ('footer.php');

?>