<?php
session_start();
header("Content-Type: application/json");

require_once "../config/db.php";

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if (!isset($_GET['internship_id'])) {
    echo json_encode(["status" => "error", "message" => "Internship ID missing"]);
    exit;
}

$companyEmail = $_SESSION['email'];
$internshipId = intval($_GET['internship_id']);

$sql = "
SELECT 
    a.application_id,
    a.status,
    a.date_applied,
    s.full_name,
    s.skills,
    s.resume
FROM Application a
JOIN Internship i ON a.internship_id = i.internship_id
JOIN Student s ON a.Semail = s.email
WHERE a.internship_id = ?
AND i.email = ?
ORDER BY a.date_applied DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $internshipId, $companyEmail);
$stmt->execute();

$result = $stmt->get_result();
$applications = [];

while ($row = $result->fetch_assoc()) {
    $applications[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $applications
]);
