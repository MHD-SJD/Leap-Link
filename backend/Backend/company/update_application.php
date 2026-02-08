<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
session_start();

require_once "../config/db.php";

/* ---------- SESSION CHECK ---------- */
if (!isset($_SESSION['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired"
    ]);
    exit;
}

$company_email = $_SESSION['email'];

/* ---------- INPUT ---------- */
$app_id = $_POST['application_id'] ?? '';
$status = $_POST['status'] ?? '';

$allowedStatus = ["Interviewing", "Rejected", "Hired"];

if (!$app_id || !in_array($status, $allowedStatus)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid input"
    ]);
    exit;
}

/* ---------- OWNERSHIP CHECK + UPDATE ---------- */
$sql = "
UPDATE Application a
JOIN Internship i ON a.internship_id = i.internship_id
SET a.status = ?
WHERE a.application_id = ?
  AND i.email = ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("sis", $status, $app_id, $company_email);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "updated"]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Not authorized or already updated"
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
exit;

