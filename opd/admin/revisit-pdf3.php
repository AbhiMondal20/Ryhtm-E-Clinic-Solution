<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    $login_username = $_SESSION['username'];
} else {
    echo "<script>location.href='../../`index`';</script>";
}

include ('../../db_conn.php');
require ('../vendor/autoload.php');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A5-L',
    'allow_remote_images' => true,
    'debug' => true,
    'margin_top' => 125,
    'margin_bottom' => 25,
]);

$mpdf->SetHTMLHeader('
    <link rel="icon" href="images/icon-1.svg">
');
            $opid = $_GET['opid'];
$rno = $_GET['rno'];

// Correct the SQL query
$sql = "SELECT `id`, `rno`, `opid`, `rfname`, `rmname`, `rlname`, `rsex`, `rage`, `phone`, `radd1`, `dept`, `revisitDate`, 
        `rdocname`, `wamt`, `discount`, `discountAmt`, `billAmount`, `paymentType`  FROM `revisit` 
        WHERE opid = '$opid' AND rno = '$rno'";

$stmt = mysqli_query($conn, $sql);

// Check for errors
if ($stmt === false) {
    die('Error: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $rno = $row['rno'];
    $opid = $row['opid'];
    // Construct fullname
    $fullname = $row['rfname'] . ' ' . $row['rmname'] . ' ' . $row['rlname'];
    
    $rdocname = $row['rdocname'];
    $rage = $row['rage'];
    $rsex = $row['rsex'];
    $phone = $row['phone'];
    $wamt = $row['wamt'];
    
    // Date formatting
    $revisitDate = $row['revisitDate'];
    if ($revisitDate) {
        $rdateObj = new DateTime($revisitDate);
        $revisitDate = $rdateObj->format("d-M-Y");
    }
    
    $radd1 = $row['radd1'];

    $discount = $row['discount'];
    $discountAmt = $row['discountAmt'];
    
    // Bill amount calculations
    $billAmount = isset($row['billAmount']) ? (float)$row['billAmount'] : 0;
    
    $paymentType = $row['paymentType'];
}

$header = '
    <center>
        <div style="text-align: center; padding: 0; margin: 0;" >
            <img src="https://erp.sriscan.in/opd/admin/images/LETTER_HEAD.png" style="padding: 0; margin: 0;" />
        </div>
    </center>
    
<div class="container">
<div style="text-align: center;"><strong>REGISTRATION RECEIPT (REVISIT)</strong></div>
<span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>
    <div class="wrapper">
        <div class="box a"><strong>Name</strong>&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt">:&nbsp;'.$fullname.'</span></div>
        <div class="box b" id="age"><strong>Age & Gender</strong> &nbsp;&nbsp;<span class="txt">:&nbsp;'.$rage.' / '.$rsex.'</span></div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>Reg No</strong>&nbsp;<span class="txt">:&nbsp;'.$rno.'</span></div>
        <div class="box b" id="reg_date"><strong>Revisit Date</strong> &nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;'.$revisitDate.'</div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>OP Id:</strong>&nbsp;&nbsp;&nbsp;<span class="txt">:&nbsp;'.$opid.'</span></div>
    </div>
   <div class="wrapper">
        <div class="box b" id="reg_date"><strong>Doctor</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$rdocname.'</div>
    </div>
    <div class="wrapper">
        <div class="box a"><strong>Phone</strong>&nbsp;&nbsp;&nbsp;<span class="txt">:&nbsp;'.$phone.'</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date"><strong>Address</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;'.$radd1.'</div>
    </div>
    
    <span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>
</div>
<table id="myTable" style="margin: 0 auto; padding: 0px;">
    <thead>
        <tr>
            <th style="padding: 0 20px; font-size: 12px;">Sr. No.</th>
            <th style="padding: 0 ; font-size: 12px;">Description</th>
            <th style="padding: 0 20px; font-size: 12px;">Qty</th>
            <th style="padding: 0 20px; font-size: 12px;">Performed</th>
            <th style="padding: 0 20px; font-size: 12px;">Amount</th>
        </tr>
    </thead>
    <tbody><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>
    <tr>
    <tr>
        <td style="padding: 0 20px; text-transform: uppercase; font-size: 12px;">2</td>
        <td style="padding: 0 20px; text-transform: uppercase; font-size: 12px;">CONSULTATION OPD</td>
        <td style="padding: 0px 20px; text-transform: uppercase; font-size: 12px;">1</td>
        <td style="padding: 0px 20px; text-transform: uppercase; font-size: 12px;">'.$rdocname.'</td>
         <td style="padding: 0px 20px; text-transform: uppercase; font-size: 12px;">'.$wamt.'</td>
    </tr>
    </tbody>
</table>';

$footer = '
<div style="display: flex; justify-content: space-between;">
    </div><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span><div class="container1">
    <div class="wrapper">
        <div class="box a">Total Amount &nbsp;&nbsp;<span class="txt">₹ '.$wamt.'</span></div>
        <div class="box b" id="age">Less Adjusted: &nbsp;&nbsp;&nbsp;<span class="txt">₹ '.$discountAmt.'</span></div>
    </div>
    <div class="wrapper">
        <div class="box a">Net Payable:&nbsp;&nbsp;&nbsp;&nbsp;<span class="txt">₹ '.$billAmount.'</span></div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date">Payment Mode: &nbsp;&nbsp;'.$paymentType.'</div>
    </div>
    <div class="wrapper">
        <div class="box a">Rupees:</div>
    </div>
    <div class="wrapper">
        <div class="box b" id="reg_date">&nbsp;</div>
    </div>
</div><span>----------------------------------------------------------------------------------------------------------------------------------------------------</span>
<div style="display: flex; justify-content: space-between;">
    <div style="text-align: left;">
        All Disputes Subject to Jurisdiction Only
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
'.$login_username.'
</div>
   
</div>';
$mpdf->SetTitle('REGISTRATION RECEIPT');
$mpdf->SetHTMLHeader($header);


$mpdf->SetHTMLFooter($footer);

$footerStyles = "<style>
#html_footer {
    position: fixed;
    bottom: -5;
    width: 100%;
    text-align: right;
}
</style>";
$mpdf->WriteHTML($footerStyles);


$css = file_get_contents('css/pdfcss.css');
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
// remove header footer line border
$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->Output();

