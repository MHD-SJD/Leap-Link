<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
session_start();

require_once "../config/db.php";

/* ---------- CHECK SESSION ---------- */
if (!isset($_SESSION['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired. Please login again."
    ]);
    exit;
}

$company_email = $_SESSION['email'];

/* ---------- GET INPUTS ---------- */
$internship_id = $_POST['internship_id'] ?? '';
$title         = $_POST['title'] ?? '';
$description   = $_POST['description'] ?? '';
$requirements  = $_POST['requirements'] ?? '';
$duration      = $_POST['duration'] ?? '';
$salary        = $_POST['salary'] ?? '';
$location      = $_POST['location'] ?? '';
$deadline      = $_POST['deadline'] ?? null;

/* ---------- VALIDATION ---------- */
if (!$internship_id || !$title || !$description) {
    echo json_encode([
        "status" => "error",
        "message" => "Required fields missing"
    ]);
    exit;
}

/* ---------- UPDATE QUERY ---------- */
$sql = "UPDATE Internship SET
            title = ?,
            description = ?,
            requirements = ?,
            duration = ?,
            salary = ?,
            location = ?,
            deadline = ?
        WHERE internship_id = ?
          AND email = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

/*
 types:
 s = string
 d = double
 i = integer
*/
$stmt->bind_param(
    "ssssdsiss",
    $title,
    $description,
    $requirements,
    $duration,
    $salary,
    $location,
    $deadline,
    $internship_id,
    $company_email
);

/* ---------- EXECUTE ---------- */
if ($stmt->execute()) {
    echo json_encode(["status" => "updated"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Execute failed: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
exit;
