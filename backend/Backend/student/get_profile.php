<?php
session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$email = $_SESSION['email'];

$sql = "SELECT 
            full_name,
            country,
            academic_year,
            field,
            profile_image
        FROM Student
        WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($data) {
    echo json_encode([
        "status" => "success",
        "profile" => $data
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Profile not found"
    ]);
}
