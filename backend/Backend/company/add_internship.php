<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
session_start();
require_once "../config/db.php";

/* ---------------- SESSION CHECK ---------------- */
if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

$email = $_SESSION['email'];

/* ---------------- COMPANY EXIST CHECK ---------------- */
$check = $conn->prepare("SELECT email FROM Company WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Company profile not created yet. Please complete company profile first."
    ]);
    exit;
}
$check->close();

/* ---------------- INPUTS ---------------- */
$title        = trim($_POST['title'] ?? '');
$description  = trim($_POST['description'] ?? '');
$requirements = trim($_POST['requirements'] ?? '');
$duration     = trim($_POST['duration'] ?? '');
$category     = strtolower(trim($_POST['category'] ?? ''));
$location     = trim($_POST['location'] ?? '');
$salary       = trim($_POST['salary'] ?? '');
$deadline     = trim($_POST['deadline'] ?? '');

/* ---------------- VALIDATION ---------------- */
if ($title === '' || $description === '' || $category === '') {
    echo json_encode(["status" => "error", "message" => "Required fields missing"]);
    exit;
}

/* ---------------- NORMALIZE ---------------- */
$salary   = ($salary === '') ? null : floatval($salary);
$deadline = ($deadline === '') ? null : $deadline;

/* ---------------- INSERT ---------------- */
$sql = "INSERT INTO Internship
(email, category, title, description, requirements, duration, salary, location, deadline, date_posted)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => $conn->error]);
    exit;
}

$stmt->bind_param(
    "ssssssdss",
    $email,
    $category,
    $title,
    $description,
    $requirements,
    $duration,
    $salary,
    $location,
    $deadline
);

if ($stmt->execute()) {
    echo json_encode(["status" => "posted"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
