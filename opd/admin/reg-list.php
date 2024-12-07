<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>
<script>
    new DataTable('#example', {
        columnDefs: [{ orderable: false, targets: 0 }],
        order: [[1, 'asc']]
    });
</script>
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
                                <li class="breadcrumb-item active" aria-current="page">Registration List</li>
                                <li class="breadcrumb-item active" ><a class="btn btn-sm btn-info text-white" onclick="goBack()"><i class="fa-solid fa-backward"></i> Back</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-right">
                    <a href="reg" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> New Registration</a>
                </div>

            </div>
        </div>
        
          <section class="content1 m-3">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form novalidate method="POST" action="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>Form Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="from" placeholder="DD-MM-YYYY"
                                                    class="form-control" required value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <h5>To Date <span class="text-danger">*</span></h5>
                                                <input type="date" name="to" placeholder="DD-MM-YYYY"
                                                    class="form-control" required value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="controls mt-4">
                                                <h5><span class="text-danger"></span></h5>
                                                <button type="submit" name="search"
                                                    class="btn btn-primary btn-md">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
        
        
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>Reg. No.</th>
                                        <th>Reg. Date Time.</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <!-- <th>F/H/S/D/W</th> -->
                                        <th>Ph. No</th>
                                        <th>City</th>
                                        <th>Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     if (isset($_POST['search'])) {

                                    $to = $_POST['to'];
                                    $from = $_POST['from'];
                                
                                    // Validate and sanitize inputs
                                    $from = mysqli_real_escape_string($conn, $from);
                                    $to = mysqli_real_escape_string($conn, $to);
                                
                                    // Ensure the dates are in quotes for SQL
                                    $sql = "SELECT id, rno, opid, rdate, rtime, rfname, 
                                                CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, 
                                                rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy, uploadPrescription 
                                                FROM registration 
                                                WHERE DATE(rdate) BETWEEN '$from' AND '$to'";
                                     }else{
                                           $sql = "SELECT id, rno, opid, rdate, rtime, rfname, CONCAT(rfname, ' ', COALESCE(rmname, ''), ' ', rlname) AS fullname, rsex, rage, fname, phone, radd1, rcity, rdist, wamt, addedBy, uploadPrescription
                                            FROM registration";
                                     }

    $stmt = mysqli_query($conn, $sql);

    if ($stmt === false) {
        die("Error executing query: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_array($stmt)) {
        $rno = $row['rno'];
        $id = $row['id'];
        $rfname = $row['rfname'];
        $wamt = number_format($row['wamt'], 2);
        $opid = $row['opid'];
        $uploadPrescription = $row['uploadPrescription'];
        ?>
        <tr>
            <td><?php echo $rno; ?></td>
            <td><?php echo $row['rdate']; ?>/<?php echo $row['rtime']; ?></td>
            <td><?php echo $row['fullname']; ?></td>
            <td><?php echo $row['rsex']; ?></td>
            <td><?php echo $row['rage']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['radd1']; ?></td>
            <td><?php echo $wamt; ?></td>
            <td class="text-center">
                <div class="list-icons d-inline-flex">
                    <div class="list-icons-item dropdown">
                        <a href="#" class="list-icons-item dropdown-toggle"
                           data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-file-text"></i></a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="reg-pdf?opid=<?php echo $opid ?>&rno=<?php echo $rno ?>"
                               class="dropdown-item"><i class="fa fa-print"></i> Print</a>
                            <div class="dropdown-divider"></div>
                            <a href="update-reg?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                               class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                            <div class="dropdown-divider"></div>
                            <a href="visit-doctor?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                               class="dropdown-item"><i class="fa-solid fa-user-doctor"></i> Visit Doctor</a>
                            <a href="opd-billing2?id=<?php echo $id; ?>&rno=<?php echo $rno; ?>"
                               class="dropdown-item">OPD Billing</a>
                            <?php
                            if ($uploadPrescription === NULL) {
                                echo '<a href="upload-prescription?id=' . $id . '&rno=' . $rno . '" class="dropdown-item" target="_BLANK"><i class="fa-solid fa-upload"></i> Prescription</a>';
                            } else {
                                echo '<a href="uploadPrescriptionPreview?rno=' . $rno . '&opid=' . $opid . '" class="dropdown-item" target="_BLANK"><i class="fa-solid fa-prescription"></i>Prescription</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php
}

                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
</div>

<?php
include ('footer.php');
?>