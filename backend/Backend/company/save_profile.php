<?php
session_start();
require_once "../config/db.php"; // DB connection

header("Content-Type: application/json");

if (!isset($_SESSION['email'])) {
    echo json_encode(["status"=>"error","message"=>"Session expired"]);
    exit;
}

$email = $_SESSION['email'];

$company_name  = $_POST['company_name'] ?? '';
$location      = $_POST['company_location'] ?? '';
$industry      = $_POST['industry'] ?? '';
$website       = $_POST['website'] ?? '';
$description   = $_POST['description'] ?? '';

/* ---------------- UPLOAD DIRECTORIES ---------------- */
$logoDir = __DIR__ . "/../uploads/company_logos/";

if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);

/* ---------------- COMPANY LOGO ---------------- */
$logoName = null;
if (!empty($_FILES['logo']['name'])) {
    $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $logoName = uniqid("logo_") . "." . $ext;

    move_uploaded_file($_FILES['logo']['tmp_name'], $logoDir . $logoName);
}

/* ---------------- SQL (Insert or Update) ---------------- */
$sql = "INSERT INTO Company
(email, company_name, location, industry, website, description, logo)
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE
company_name = VALUES(company_name),
location = VALUES(location),
industry = VALUES(industry),
website = VALUES(website),
description = VALUES(description),
logo = IFNULL(VALUES(logo), logo)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssss",
    $email,
    $company_name,
    $location,
    $industry,
    $website,
    $description,
    $logoName
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "logo"   => $logoName ? "Backend/uploads/company_logos/" . $logoName : "Backend/uploads/company_logos/default-logo.png"
    ]);
} else {
    echo json_encode(["status"=>"error","message"=>$stmt->error]);
}
?>
