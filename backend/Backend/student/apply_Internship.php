<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

/* ---------------- LOGIN CHECK ---------------- */
if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Please login first"]);
    exit;
}

$studentEmail = $_SESSION['email'];
$internshipId = $_POST['internship_id'] ?? null;

/* ---------------- BASIC VALIDATION ---------------- */
if (!$internshipId) {
    echo json_encode(["status" => "error", "message" => "Invalid internship"]);
    exit;
}

/* ---------------- ROLE CHECK (STUDENT ONLY) ---------------- */
$roleCheck = $conn->prepare("SELECT role FROM users WHERE email = ?");
$roleCheck->bind_param("s", $studentEmail);
$roleCheck->execute();
$result = $roleCheck->get_result()->fetch_assoc();

if (!$result || $result['role'] !== 'user') {
    echo json_encode(["status" => "error", "message" => "Only students can apply"]);
    exit;
}

/* ---------------- STUDENT PROFILE CHECK ---------------- */
$studentCheck = $conn->prepare("SELECT email FROM Student WHERE email = ?");
$studentCheck->bind_param("s", $studentEmail);
$studentCheck->execute();
$studentCheck->store_result();

if ($studentCheck->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Please complete your student profile first"
    ]);
    exit;
}

/* ---------------- APPLY ---------------- */
$sql = "INSERT INTO Application (Semail, internship_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => $conn->error]);
    exit;
}

try {
    $stmt->bind_param("si", $studentEmail, $internshipId);
    $stmt->execute();

    echo json_encode(["status" => "success", "message" => "Application submitted"]);
} catch (mysqli_sql_exception $e) {
    // Duplicate application (UNIQUE constraint)
    echo json_encode(["status" => "error", "message" => "You already applied"]);
}

$stmt->close();
$conn->close();
