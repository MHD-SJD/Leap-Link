<?php
session_start();
require_once "C:/Users/SAJJAD/Desktop/Final Project/WEB-Final/Backend/config/db.php";

header("Content-Type: application/json");

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Session expired"]);
    exit;
}

$email = $_SESSION['email'];

$fullName  = $_POST['full_name'] ?? '';
$academic  = $_POST['academic_year'] ?? '';
$country   = $_POST['country'] ?? '';
$field     = $_POST['field'] ?? '';
$skills    = $_POST['skills'] ?? '';
$portfolio = $_POST['portfolio_link'] ?? '';
$summary   = $_POST['summary'] ?? '';

/* ---------------- UPLOAD DIRECTORIES ---------------- */
$profileDir = __DIR__ . "../../uploads/profile_images/";
$resumeDir  = __DIR__ . "../../uploads/resumes/";

if (!is_dir($profileDir)) mkdir($profileDir, 0777, true);
if (!is_dir($resumeDir))  mkdir($resumeDir, 0777, true);

/* ---------------- PROFILE IMAGE ---------------- */
$profileImageName = null;

if (!empty($_FILES['profile_image']['name'])) {
    $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
    $profileImageName = uniqid("profile_") . "." . $ext;

    move_uploaded_file(
        $_FILES['profile_image']['tmp_name'],
        $profileDir . $profileImageName
    );
}

/* ---------------- RESUME ---------------- */
$resumeName = null;

if (!empty($_FILES['resume']['name'])) {
    $ext = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
    $resumeName = uniqid("resume_") . "." . $ext;

    move_uploaded_file(
        $_FILES['resume']['tmp_name'],
        $resumeDir . $resumeName
    );
}

/* ---------------- SQL ---------------- */
$sql = "INSERT INTO Student
(email, full_name, academic_year, country, field, skills, portfolio_link,
 professional_summary, profile_image, resume)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE
full_name = VALUES(full_name),
academic_year = VALUES(academic_year),
country = VALUES(country),
field = VALUES(field),
skills = VALUES(skills),
portfolio_link = VALUES(portfolio_link),
professional_summary = VALUES(professional_summary),
profile_image = IFNULL(VALUES(profile_image), profile_image),
resume = IFNULL(VALUES(resume), resume)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssss",
    $email,
    $fullName,
    $academic,
    $country,
    $field,
    $skills,
    $portfolio,
    $summary,
    $profileImageName, // ONLY filename
    $resumeName        // ONLY filename
);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}
