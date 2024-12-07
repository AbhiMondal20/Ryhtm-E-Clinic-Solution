<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../index';</script>";
}
include ('header.php');

$id = $_GET['id'];
$sql = "SELECT id, pMode FROM paymentmode WHERE id = '$id'";
$stmt = mysqli_query($conn, $sql);
if ($stmt === false) {
    die(print_r(mysqli_errors(), true));
}
while ($row = mysqli_fetch_array($stmt)) {
    $id = $row['id'];
    $pMode = $row['pMode'];
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
                                            <input type="text" name="pMode" value="<?php echo $pMode; ?>" placeholder="" class="form-control" required
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
    </div>
</div>
<!-- /.content-wrapper -->


<?php
    if (isset($_POST['save'])) {
        $pMode = $_POST['pMode'];

            $sql = "UPDATE paymentmode SET pMode = '$pMode' Where id = '$id'";
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
    include ('footer.php');
?>