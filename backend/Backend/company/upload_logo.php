<?php
header("Content-Type: application/json");
session_start();

require_once "../config/db.php";

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== 0) {
    echo json_encode(["status" => "error", "message" => "No file uploaded"]);
    exit;
}

$email = $_SESSION['email'];

// Create uploads folder if it doesn't exist
$uploadDir = "../uploads/company_logos/";
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// Generate unique filename
$fileExt = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
$filename = "logo_" . uniqid() . "." . $fileExt;
$targetFile = $uploadDir . $filename;

// Move uploaded file
if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {

    // Update DB
    $stmt = $conn->prepare("UPDATE Company SET logo=? WHERE email=?");
    $stmt->bind_param("ss", $filename, $email);
    $stmt->execute();

    echo json_encode(["status" => "uploaded", "logo" => $filename]);
} else {
    echo json_encode(["status" => "error", "message" => "Upload failed"]);
}
?>
