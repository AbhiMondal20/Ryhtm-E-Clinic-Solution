<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../index';</script>";
}
include ('header.php');


if (isset($_GET['type']) && $_GET['type'] === 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $sql2 = "DELETE FROM paymentmode WHERE id = ?";
    $stmt = $conn->prepare($sql2);

    if ($stmt === false) {
        die("Error preparing the statement: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
                swal('Success!', '', 'success');
                setTimeout(function(){
                    window.location.href = 'payment-mode';
                }, 2000);
              </script>";
        exit;
    } else {
        die("Error executing the statement: " . htmlspecialchars($stmt->error));
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

                                <li class="breadcrumb-item" aria-current="page">Payment</li>
                                <li class="breadcrumb-item active" aria-current="page">Mode</li>
                                <li class="breadcrumb-item active" ><a class="btn btn-sm btn-info text-white" onclick="goBack()"><i class="fa-solid fa-backward"></i> Back</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                    <div class="text-right">
                    <a href="add-payment-mode" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> Add Paymetn Mode</a>
                </div>

            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-hover display nowrap margin-top-10 w-p100">
                                <thead>
                                    <tr>
                                        <th>SL. No</th>
                                        <th>Payment Mode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT id, pMode FROM paymentmode 
                                    ORDER BY id DESC";
                                    $stmt = mysqli_query($conn, $sql);
                                    if ($stmt === false) {
                                        die(print_r(mysqli_errors(), true));
                                    }
                                    $sno = 0;
                                    while ($row = mysqli_fetch_array($stmt)) {
                                        $id = $row['id'];
                                        $pMode = $row['pMode'];
                                        $sno = $sno + 1;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $sno; ?>
                                            </td>
                                            <td>
                                                <?php echo $pMode; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="list-icons d-inline-flex">
                                                    <div class="list-icons-item dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-file-text"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <div class="dropdown-divider"></div>
                                                            <a href="update-payment-mode?id=<?php echo $id; ?>"
                                                                class="dropdown-item"><i class="fa fa-pencil"></i> Edit</a>
                                                                <a href="javascript:void(0)" onclick="return confirmDelete(<?php echo $id; ?>);" class="delete dropdown-item"><i class="fa-solid fa-trash"></i> Delete</a>

                                                        </div>
                                                    </div>
                                                </div>
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
<script>
function confirmDelete(id) {
    swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this session!',
        icon: 'warning',
        buttons: {
            cancel: {
                text: 'Cancel',
                visible: true,
                closeModal: true
            },
            confirm: {
                text: 'Yes, delete it!',
                value: true,
                visible: true,
                closeModal: true
            }
        }
    }).then((value) => {
        if (value) {
            window.location.href = "?type=delete&id=" + id;
        }
    });
    return false;
}
</script>

<?php
include ('footer.php');

?>