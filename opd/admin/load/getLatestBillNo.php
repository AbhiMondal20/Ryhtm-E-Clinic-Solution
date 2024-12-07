<?php
session_start();

include('../../../db_conn.php');

// Check if the session already has a bill number reserved
if (isset($_SESSION['reserved_billno'])) {
    $next_billno = $_SESSION['reserved_billno']; 
    echo json_encode(['next_billno' => $next_billno]);
    exit;
}

// If no bill number is reserved yet, we fetch and reserve a new one

// Start a transaction to ensure atomicity
if (!mysqli_begin_transaction($conn)) {
    die(json_encode(['error' => 'Failed to start transaction: ' . mysqli_error($conn)]));
}

// SQL to get and update the latest bill number atomically
$sql = "SELECT last_billno FROM billno_sequence FOR UPDATE";  // Lock the row for update
$stmt = mysqli_query($conn, $sql);

if ($stmt === false) {
    mysqli_rollback($conn); // Rollback the transaction on error
    die(json_encode(['error' => 'Query failed: ' . mysqli_error($conn)]));
}

$row = mysqli_fetch_array($stmt, MYSQLI_ASSOC);

if ($row) {
    $last_billno = $row['last_billno'];
    $next_billno = $last_billno + 1;

    // Update the bill number in the billno_sequence table
    $update_sql = "UPDATE billno_sequence SET last_billno = '$next_billno'";
    if (!mysqli_query($conn, $update_sql)) {
        mysqli_rollback($conn); // Rollback the transaction on error
        die(json_encode(['error' => 'Failed to update bill number: ' . mysqli_error($conn)]));
    }
} else {
    mysqli_rollback($conn);
    die(json_encode(['error' => 'No bill number found. Please initialize the billno_sequence table.']));
}

// Commit the transaction to finalize the bill number update
if (!mysqli_commit($conn)) {
    mysqli_rollback($conn); // Rollback if commit fails
    die(json_encode(['error' => 'Failed to commit transaction: ' . mysqli_error($conn)]));
}

// Store the new bill number in session
$_SESSION['reserved_billno'] = $next_billno;

// Optionally, reserve the bill number in another table for the current user
$reserve_sql = "INSERT INTO billing_temp (billno, created_at) VALUES ('$next_billno', NOW())";
if (!mysqli_query($conn, $reserve_sql)) {
    die(json_encode(['error' => 'Failed to reserve bill number: ' . mysqli_error($conn)]));
}

// Return the next bill number in JSON format
echo json_encode(['next_billno' => $next_billno]);

// Close the database connection
mysqli_close($conn);
?>
