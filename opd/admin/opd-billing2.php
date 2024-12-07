<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include 'header.php';
date_default_timezone_set("asia/kolkata");

$id = "";
$rno = "";
$opid = "";
$fullname = "";
$rdocname = "";
$phone = "";

if (isset($_GET['opid'])) {
    $opid = $_GET['opid'];
}

if (isset($_GET['rno'])) {
    $rno = $_GET['rno'];
}

$sql = "SELECT id, rno, opid, phone, CONCAT(rfname, ' ', IFNULL(rmname, ''), ' ', rlname) AS fullname, rage, rdocname
        FROM registration WHERE rno = '$rno' OR opid = '$opid'";
$stmt = mysqli_query($conn, $sql);

if ($stmt === false) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
        if($row){
        $id = $row['id'];
        $rno = $row['rno'];
        $opid = $row['opid'];
        $fullname = $row['fullname'];
        $rdocname = $row['rdocname'];
        $phone = $row['phone'];
        $rage = $row['rage'];
        }else{
            $rage = 0;
        }
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
                                <li class="breadcrumb-item active" aria-current="page">Billing</li>
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
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>Reg. No. <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="rno" readonly placeholder="Reg. No" class="form-control"
                                                    required value="<?php echo $rno; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <h5>OP ID <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="opid" readonly placeholder="OP Id" class="form-control"
                                                    required value="<?php echo $opid; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>First Name <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" readonly required name="pname"
                                                    value="<?php echo $fullname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Age <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" readonly required name="age"
                                                    value="<?php echo $rage; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Bill Date <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="datetime" class="form-control" readonly name="billdate"
                                                    value="<?php echo date('Y-m-d H:i'); ?>"
                                                    required data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Phone <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" readonly required name="phone"
                                                    value="<?php echo $phone; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Doctor <span class="text-danger">*</span></h5>
                                                <input type="text" class="form-control" readonly required name="rdocname"
                                                    value="<?php echo $rdocname; ?>"
                                                    data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <label for="">Bill Details</label>
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <h5>Bill No: <span class="text-danger">*</span></h5>
                                            <div class="controls">
                                                <input type="text" name="billno" id="billno" placeholder="237495" class="form-control" required readonly data-validation-required-message="This field is required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <form> -->
                                <div class="row">
                                   <div class="col-lg-4">
                                        <label for="Services">Services</label>
                                        <input list="servnameslist" id="servname" class="form-control servname" 
                                            oninput="delayedGetServname(this.value)" tabindex="1">
                                            <datalist id="servnameslist">
                                                <option selected disabled>Select Services</option>
                                                <?php
                                                $sql = "SELECT servname FROM servmaster";
                                                $stmt = mysqli_query($conn, $sql);
                                                if ($stmt !== false) {
                                                    while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                                                        $servname = $row['servname'];
                                                        echo "<option value='$servname'>$servname</option>";
                                                    }
                                                }
                                                ?>
                                            </datalist>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <label for="Price">Price</label>
                                        <input type="text" class="form-control servrate" id="servrate" readonly>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="add"></label>
                                        <button type="button" id="addBtn" tabindex="2"
                                            class="btn btn-md btn-primary mt-4 addBtn">Add</button>
                                    </div>
                                </div>
                                <table
                                    class="table table-bordered table-hover display nowrap margin-top-10 w-p100 dataTable">
                                    <thead>
                                        <tr>
                                            <th>Services</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="TOTAL Amount"
                                                    name="totalPrice" id="totalPrice"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Total Adjusted:</td>
                                            <td><input type="text" class="form-control" placeholder="Total Adjusted"
                                                    name="totalAdj" id="totalAdj" oninput="handleInputChange()"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Discount %:</td>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Discount %"
                                                       name="discount" id="discount" value="<?php echo ($rage >= 55) ? '20' : ''; ?>" oninput="handleInputChange()">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Special Discount %:</td>
                                            <td>
                                                <div class="demo-checkbox">
                                                    <input type="checkbox" id="basic_checkbox_2" class="filled-in" onchange="updateDiscount(this)" data-value="20"/>
                                                    <label for="basic_checkbox_2">Senior citizen welfare (20%)</label>&nbsp;&nbsp;
                                                    <input type="checkbox" id="basic_checkbox_3" class="filled-in" onchange="updateDiscount(this)" data-value="30"/>
                                                    <label for="basic_checkbox_3">Medical professional welfare (30%)</label>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2">Discount Amt.:</td>
                                            <td><input type="text" class="form-control" placeholder="Discount Amt."
                                                    name="discountAmt" id="discountAmt" oninput="handleInputChange()"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Bill Amount:</td>
                                            <td><input type="text" class="form-control" placeholder="Bill Amount"
                                                    name="billAmount" id="billAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Paid Amount:</td>
                                            <td><input type="text" class="form-control"  required data-validation-required-message="This field is required" placeholder="Paid Amount"
                                                    name="paidAmount" id="paidAmount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Balance:</td>
                                            <td><input type="text" class="form-control" placeholder="Balance"
                                                    name="balance" id="balance"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Payment Type:</td>
                                            <td>
                                                <select class="form-select select2" name="status">
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
                                            </td>
                                        </tr>
                                       
                                    </tfoot>
                                </table>
                            </div>
                            <center>
                                <div class="text-xs-right">
                                    <button type="submit" class="btn btn-info" name="billSave">SAVE</button>
                                </div>
                            </center>
                            <div class="text-xs-right mt-4">
                                <!-- <button type="clear" class="btn btn-info">CLEAR</button> -->
                                <a href="collection" class="btn btn-info">Total Collection</a>
                                <a href="delivery-report" class="btn btn-info">Delivery Report</a>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target=".bs-example-modal-lg">List of Register Patient</button>
                                <button type="button" class="btn btn-primary">List of Admitted Patient</button>
                                <button type="button" class="btn btn-info">Money Receipt</button>
                                <a href="index" class="btn btn-info"><i class="fa-solid fa-x"></i></a>
                            </div>
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
    $(document).ready(function() {
    $.ajax({
        url: 'load/getLatestBillNo.php',  // This script contains the logic to fetch the new bill number
        type: 'GET',
        dataType: 'json',
        timeout: 5000,
        success: function(data) {
            if (data.next_billno) {
                $('#billno').val(data.next_billno); 
            } else {
                console.error(data.error);
                alert('Failed to load bill number.');
            }
        },
        error: function(xhr, status, error) {
            if (status === "timeout") {
                alert('Your Internet is Too Slow. The request for the bill number timed out. Please try again.');
            } else {
                console.error('AJAX Error:', status, error);
                alert('Your Internet is Too Slow. An error occurred while fetching the bill number.');
            }
        }
    });
});
</script>

<script>
    $(document).on('keydown', '.service-entry input', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 9) {
            var $inputs = $(this).closest('.service-entry').find('input');
            var index = $inputs.index(this);
            if (index === $inputs.length - 1) {
                e.preventDefault();
                var $addBtn = $(this).closest('.service-entry').find('.addBtn');
                $addBtn.focus();
            }
        }
    });

    // Add new service entry
    $(document).on('click', '.addBtn', function () {
        var $serviceEntry = $(this).closest('.service-entry');
        var $clone = $serviceEntry.clone();

        $clone.find('input').val('');

        $('#servname').append($clone);

        $clone.find('.servname').focus();
    });
</script>

<script>
const tbodyEl = document.querySelector("tbody");
const tableEl = document.querySelector("table");
const addBtn = document.getElementById("addBtn");
const totalPriceEl = document.getElementById("totalPrice");
const totalAdjEl = document.getElementById("totalAdj");
const discountEl = document.getElementById("discount");
const billAmountEl = document.getElementById("billAmount");
const paidAmountEl = document.getElementById("paidAmount");
const balanceEl = document.getElementById("balance");
const discountAmtEl = document.getElementById("discountAmt");
let prices = [];

// Function to calculate the total price
function calculateTotalPrice() {
    // Calculate the total of all services
    let totalPrice = prices.reduce((sum, price) => sum + price, 0);

    // Get adjustment and discount values
    const totalAdj = parseFloat(totalAdjEl.value) || 0;
    const discount = parseFloat(discountEl.value) || 0;

    // Calculate adjusted total price
    const adjustedTotalPrice = totalPrice - totalAdj;

    // Calculate discount amount
    const discountAmt = (adjustedTotalPrice * discount / 100).toFixed(2);

    // Calculate final bill amount
    const billAmount = adjustedTotalPrice - discountAmt;

    // Calculate balance
    const balance = billAmount - (parseFloat(paidAmountEl.value) || 0);

    // Update the UI fields
    totalPriceEl.value = totalPrice.toFixed(2);
    discountAmtEl.value = discountAmt;
    billAmountEl.value = billAmount.toFixed(2);
    balanceEl.value = balance.toFixed(2);
}

// Event delegation to handle row addition
function onAddRow() {
    // Get the service rate and name values
    const servrate = document.getElementById("servrate").value.replace(/,/g, '').trim();
    const servname = document.getElementById("servname").value.trim();

    // Check if table body exists
    if (!tbodyEl) {
        console.error("Table body not found!");
        return;
    }

    // Input validation: Check if servname or servrate is invalid
    if (!servname || !servrate || servrate === "0" || servrate === "Price not available") {
        swal({
            title: 'Invalid service name or price!',
            icon: 'warning',
            button: 'OK',
        });
        return;
    }

    // Get all existing services in the table
    const rows = tbodyEl.querySelectorAll("tr");
    const existingServices = Array.from(rows).map(row => {
        const input = row.querySelector("td:first-child input");
        return input ? input.value.toLowerCase() : null; // Convert to lowercase
    });

    // Check if service already exists (also convert new servname to lowercase)
    if (existingServices.includes(servname.toLowerCase())) {
        swal({
            title: 'Service already added!',
            icon: 'warning',
            button: 'OK',
        }).then(() => {
            // Clear the input fields for service name and service rate
            document.getElementById("servname").value = '';
            document.getElementById("servrate").value = '';
        });
        return;
    }

    // If service is valid and not already added, append a new row
    const newRow = `
        <tr>
            <td><input class="form-control" type="text" value="${servname}" readonly name="servnames[]"></td>
            <td><input class="form-control" type="text" value="${servrate}" readonly name="servrates[]"></td>
            <td><button class="deleteBtn btn-primary btn-md">Delete</button></td>
        </tr>
    `;

    // Append the new row to the table body
    tbodyEl.innerHTML += newRow;

    // Parse the service rate as a float and add it to the price array
    prices.push(parseFloat(servrate));
    calculateTotalPrice();

    // Clear the inputs for the next entry
    document.getElementById("servname").value = '';
    document.getElementById("servrate").value = '';
}

// Event delegation to handle deleting rows dynamically
document.addEventListener('click', function (event) {
    if (event.target && event.target.classList.contains('deleteBtn')) {
        const row = event.target.closest('tr');
        const servrate = row.querySelector('td:nth-child(2) input').value;

        // Remove the row
        row.remove();

        // Update the prices array and recalculate total price
        const index = prices.indexOf(parseFloat(servrate));
        if (index !== -1) prices.splice(index, 1);
        calculateTotalPrice();
    }
});

// Add event listeners to input fields
const inputs = document.querySelectorAll("#totalAdj, #discount, #paidAmount");
inputs.forEach(input => {
    input.addEventListener("input", calculateTotalPrice);
});

// Attach event listeners to buttons
addBtn.addEventListener("click", onAddRow);
</script>


<script>

let debounceTimeout;

function delayedGetServname(servname) {
    clearTimeout(debounceTimeout);  // Clear previous timeout
    debounceTimeout = setTimeout(function() {
        getServname(servname);  // Call the function immediately (0ms delay)
    }, 0);  // Effectively making it an instant load
}

function getServname(servname) {
    if (servname === "") {
        // If the input is cleared, clear the price field immediately
        $("#servrate").val("");
        return;
    }

    $.ajax({
        url: "load/fetch_price.php",
        type: "POST",
        data: { servname: servname },
        dataType: "json",
        success: function (data) {
            if (data.length > 0) {
                $("#servrate").val(data[0].servrate);  // Set the price
            } else {
                $("#servrate").val("");  // If no data returned
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

</script>

<script>
    function updateDiscount(checkbox) {
        const discountInput = document.getElementById('discount');
        const discountAmtInput = document.getElementById('discountAmt');
        const totalPriceElement = document.getElementById('totalPrice');
        
        // Ensure totalAmount is a number
        const totalAmount = parseFloat(totalPriceElement.value) || 0;

        if (checkbox.checked) {
            // Update the discount % value
            const discountPercentage = parseFloat(checkbox.getAttribute('data-value'));
            discountInput.value = discountPercentage;

            // Calculate and update the discount amount
            const discountAmount = (totalAmount * discountPercentage) / 100;
            discountAmtInput.value = discountAmount.toFixed(2); // Format to 2 decimal places

            // Uncheck other checkboxes
            const checkboxes = document.querySelectorAll('.demo-checkbox input[type="checkbox"]');
            checkboxes.forEach(cb => {
                if (cb !== checkbox) cb.checked = false;
            });
        } else {
            // Clear both fields if the checkbox is unchecked
            discountInput.value = '';
            discountAmtInput.value = '';
        }
    }
</script>


<script>
    // Get the age from PHP
    let rage = <?php echo $rage; ?>;

    // Function to handle input change
    function handleInputChange() {
        const discountField = document.getElementById("discount");

        // If age is 55 or more, set discount to 20
        if (rage >= 55) {
            discountField.value = "20";
        }
    }

    // Trigger the check on page load
    window.onload = handleInputChange;
    
  
    
</script>

<!-- Load catemaster -->
<script>
    function loadServices() {
            var catemaster = document.getElementById('catemaster').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'load/get_services.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update servnameslist datalist
                        var servnameslist = document.getElementById('servnameslist');
                        servnameslist.innerHTML = "<option selected disabled>Select Doctor</option>";
                        response.servnames.forEach(function (servname) {
                            servnameslist.innerHTML += "<option value='" + servname + "'>" + servname + "</option>";
                        });
                        document.getElementById('servrate').value = response.servrate;
                    } else {
                        console.log(response.error);
                    }
                }
            };
            xhr.send('catemaster=' + catemaster);
        }

</script>


<!-- servname clear and teb retab -->
<script>
    document.getElementById('addBtn').addEventListener('click', function () {
        document.getElementById('servname').value = '';
        document.getElementById('servname').focus();
    });
</script>

<!-- If totalAdj put then Discount% and DiscountAmt readonly then put Discount% and DiscountAmt  -->
<!-- put then totalAdj readolny -->
<script>
    function handleInputChange() {
        var totalAdj = document.getElementById("totalAdj").value;
        var discount = document.getElementById("discount").value;
        var discountAmt = document.getElementById("discountAmt");

        if (totalAdj) {
            document.getElementById("discount").readOnly = true;
            discountAmt.readOnly = true;
        } else if (discount) {
            document.getElementById("totalAdj").readOnly = true;
        } else {
            document.getElementById("discount").readOnly = false;
            discountAmt.readOnly = false;
            document.getElementById("totalAdj").readOnly = false;
        }
    }
</script>

<!-- List of Register Patient -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">List of Register Patient</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example5" class="table nowrap margin-top-10 w-p100">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Reg. No.</th>
                                <th>OP Id</th>
                                <th>Reg. Date Time.</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Ph. No</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$sql = "SELECT id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy
                        FROM registration
                        ORDER BY id DESC";
$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $rno = $row['rno'];
    $opid = $row['opid'];
    $fullname = $row['fullname'];
    $rdate = $row['rdate'];
    $rtime = date('H:i A', strtotime($row['rtime'])); 
    $rsex = $row['rsex'];
    $rage = $row['rage'];
    $phone = $row['phone'];
    ?>
                                <tr>
                                    <td>
                                        <a href="?opid=<?php echo htmlspecialchars($opid); ?>&rno=<?php echo htmlspecialchars($rno); ?>"
                                            class="btn btn-sm btn-primary"><i class="fa-solid fa-file-invoice"></i></a>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rno); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($opid); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rdate); ?>&nbsp;
                                        <?php echo htmlspecialchars($rtime); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($fullname); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rsex); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($rage); ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($phone); ?>
                                    </td>
                                </tr>
                                <?php
}
?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php

if (isset($_POST['billSave'])) {
    $errorOccurred = false;

    $rno = $conn->real_escape_string($_POST['rno']);
    $opid = $conn->real_escape_string($_POST['opid']);
    $pname = $conn->real_escape_string($_POST['pname']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $rdocname = $conn->real_escape_string($_POST['rdocname']);
    $billno = $conn->real_escape_string($_POST['billno']);
    $billdate = $conn->real_escape_string($_POST['billdate']);
    $totalPrice = $conn->real_escape_string($_POST['totalPrice']);
    $totalAdjset = (float)$conn->real_escape_string($_POST['totalAdj']);
    $discountAmt = (float)$conn->real_escape_string($_POST['discountAmt']);

    // Validate discount inputs
    if ($totalAdjset === '' || $discountAmt === '') {
        echo "<script>alert('Invalid input for Discount');</script>";
        $errorOccurred = true;
    }

    $totalAdj = $totalAdjset + $discountAmt;

    $discount = $conn->real_escape_string($_POST['discount']);
    $billAmount = $conn->real_escape_string($_POST['billAmount']);
    $paidAmount = $conn->real_escape_string($_POST['paidAmount']);
    $balance = $conn->real_escape_string($_POST['balance']);
    $status = $conn->real_escape_string($_POST['status']);
    $username = $login_username;

    // Validate numeric fields
    if (!is_numeric($balance) || $balance < 0 || !is_numeric($paidAmount)) {
        echo "<script>alert('Invalid Amounts');</script>";
        $errorOccurred = true;
    }

    // Validate service names
    if (!isset($_POST['servnames']) || !is_array($_POST['servnames']) || empty($_POST['servnames'])) {
        echo "<script>alert('No services found');</script>";
        $errorOccurred = true;
    }

    // Check if the bill number already exists
    $checkBillNo = "SELECT billno FROM billingdetails WHERE billno = '$billno'";
    $result = mysqli_query($conn, $checkBillNo);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Bill number already exists!');</script>";
        $errorOccurred = true;
    }

    if ($errorOccurred) {
        echo "<script>window.location.href=window.location.href;</script>";
        return; // Stop further execution if errors occurred
    }

    // Prepare the SQL statement for billing details
    $sql = "INSERT INTO billingdetails (rno, pname, phone, rdocname, billno, billdate, totalPrice, totalAdj, discount, billAmount, paidAmount, balance, status, uname, opid)
            VALUES ('$rno', '$pname', '$phone', '$rdocname', '$billno', '$billdate', '$totalPrice', '$totalAdj', '$discount', '$billAmount', '$paidAmount', '$balance', '$status', '$username', '$opid')";

    if (mysqli_query($conn, $sql)) {
        // Loop through services and save them
        foreach ($_POST['servnames'] as $i => $servnames) {
            $servnames = $conn->real_escape_string($servnames);
            $servrates = $conn->real_escape_string($_POST['servrates'][$i]);

            if (trim($servnames) === '') {
                echo "<script>alert('Invalid service name provided');</script>";
                $errorOccurred = true;
                break; // Stop looping if there's an invalid service
            }

            // Insert service into billing
            $sql = "INSERT INTO billing (rno, pname, billno, billdate, servname, servrate, uname, opid)
                    VALUES ('$rno', '$pname', '$billno', '$billdate', '$servnames', '$servrates', '$username', '$opid')";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                // On successful insertion, open the generated PDF and refresh the page
                echo '<script>
                    window.open("mpdfview?rno=' . $rno . '&billno=' . $billno . '&billdate=' . $billdate . '");
                    window.location.href=window.location.href;
                 </script>';
            } else {
                echo "Error: " . mysqli_error($conn);
                $errorOccurred = true;
                break; // Stop looping if there's an error
            }
        }

        if (!$errorOccurred) {
            // **Step 1: Clear the reserved bill number from the session after successful save**
            if (isset($_SESSION['reserved_billno'])) {
                unset($_SESSION['reserved_billno']);
            }

            // Optionally, delete the temporary reservation from the `billing_temp` table
            $delete_sql = "DELETE FROM billing_temp WHERE billno = '$billno'";
            mysqli_query($conn, $delete_sql);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

include 'footer.php';

?>