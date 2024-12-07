<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../login';</script>";
}
include ('header.php');
?>

<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-user-plus"></i>
                                </h1>
                                <?php
                                $date = date('Y-m-d');
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration WHERE rdate = '$date'";
                                $stmt = mysqli_query($conn, $sql);
                                if ($stmt) {
                                    $row = mysqli_fetch_assoc($stmt);
                                    $total = $row['totalRegistrations'];
                                } else {
                                    $total = 0;
                                   
                                }
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>

                                <span class="badge badge-pill badge-success px-10 mb-10">New OPD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-user-plus"></i>
                                </h1>
                                <?php
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM registration";
                                $stmt = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($stmt);
                                $total = $row['totalRegistrations'];
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>
                                <span class="badge badge-pill badge-success px-10 mb-10">Old OPD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-rupee-sign"></i></h1>
                               <?php
                                 $sql = "SELECT SUM(CAST(bd.paidAmount AS DECIMAL(18, 2))) AS totallabp 
                                        FROM billingdetails AS bd 
                                        WHERE bd.paidAmount IS NOT NULL AND DATE(bd.billdate) = '$date'";
                                $stmt = mysqli_query($conn, $sql);
                               
                               if ($stmt === false) {
                                   die("Error: " . mysqli_error($conn));
                               }
                               
                               $row = mysqli_fetch_assoc($stmt);
                               if ($row === null) {
                                   die("No data returned.");
                               }
                               
                               $totallabp = $row['totallabp'];
                               ?>
                               
                               <h2>
                                   <?php echo '₹'.$totallabp; ?>
                               </h2>
                                
                                <span class="badge badge-pill badge-success px-10 mb-10">Collection</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-rupee-sign"></i></h1>
                               <?php
                                 $sql = "SELECT SUM(CAST(rd.paidAmount AS DECIMAL(18, 2))) AS returnAmount 
                                        FROM returnbillingdetails AS rd 
                                        WHERE rd.paidAmount IS NOT NULL AND DATE(rd.billdate) = '$date'";
                                $stmt = mysqli_query($conn, $sql);
                               
                               if ($stmt === false) {
                                   die("Error: " . mysqli_error($conn));
                               }
                               
                               $row = mysqli_fetch_assoc($stmt);
                               if ($row === null) {
                                   die("No data returned.");
                               }
                               
                               $returnAmount = $row['returnAmount'];
                             
                               ?>
                               
                               <h2>
                                   <?php echo '₹'.$returnAmount; ?>
                               </h2>
                                
                                <span class="badge badge-pill badge-success px-10 mb-10">Return Amount</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                  <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-rupee-sign"></i></h1>
                               <?php
                                    $totalCollection = $totallabp - $returnAmount
                               ?>
                               
                               <h2>
                                   <?php echo '₹'. $totalCollection; ?>
                               </h2>
                                
                                <span class="badge badge-pill badge-success px-10 mb-10">Today Collection</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-rupee-sign"></i></h1>
                              <?php
                                        $sql = "SELECT 
                                                    SUM(b.paidamount) AS total_paid,
                                                    SUM(rb.paidamount) AS total_returned,
                                                    (SUM(b.paidamount) - SUM(rb.paidamount)) AS balance
                                                FROM 
                                                    billingdetails AS b
                                                LEFT JOIN 
                                                    returnbillingdetails AS rb ON b.billno = rb.billno;";
                                        
                                        $res = mysqli_query($conn, $sql);
                                    
                                        // Check if query executed successfully
                                        if ($res) {
                                            $row = mysqli_fetch_assoc($res); // Corrected to 'mysqli_fetch_assoc'
                                            $balance = isset($row['balance']) ? $row['balance'] : 0;
                                        } else {
                                            // Handle the error if the query fails
                                            $balance = 0;
                                            echo 'Error: ' . mysqli_error($conn);
                                        }
                                    ?>
                                    
                                    <h2>
                                        <?php echo '₹' . number_format($balance, 2); // Format the balance with 2 decimal places ?>
                                    </h2>

                                
                                <span class="badge badge-pill badge-success px-10 mb-10">Total Collection</span>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-xl-2 col-md-6 col-6">
                    <div class="box">
                        <div class="box-body">
                            <div class="text-center">
                                <h1 class="fs-50 text-success"><i class="fa-solid fa-calendar-days"></i>
                                </h1>
                                <?php
                                $date = date('Y-m-d');
                                $sql = "SELECT COUNT(*) AS totalRegistrations FROM online_patient";
                                $stmt = mysqli_query($conn, $sql);
                                if ($stmt) {
                                    $row = mysqli_fetch_assoc($stmt);
                                    $total = $row['totalRegistrations'];
                                } else {
                                    $total = 0;
                                }
                                ?>
                                <h2>
                                    <?php echo $total; ?>
                                </h2>

                                <span class="badge badge-pill badge-success px-10 mb-10">Online Booking</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<?php
include ('footer.php');
?>