<?php
require_once "../config/db.php";

$response = [];

/* ================= TOTAL USERS ================= */
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);
$response['total_users'] = $result->fetch_assoc()['total_users'];

/* ================= ACTIVE INTERNSHIPS ================= */
$sql = "SELECT COUNT(*) AS active_internships 
        FROM Internship 
        WHERE deadline >= CURDATE()";
$result = $conn->query($sql);
$response['active_internships'] = $result->fetch_assoc()['active_internships'];

/* ================= NEW SIGNUPS TODAY ================= */
$sql = "SELECT COUNT(*) AS new_signups 
        FROM users 
        WHERE DATE(created_at) = CURDATE()";
$result = $conn->query($sql);
$response['new_signups'] = $result->fetch_assoc()['new_signups'];

/* ================= REPORTED POSTS ================= */
/* You don't have reports table yet */
$response['reported_posts'] = 0;

header("Content-Type: application/json");
echo json_encode($response);
?>
