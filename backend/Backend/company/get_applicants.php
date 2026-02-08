<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

session_start();
require_once "../config/db.php";

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Session expired"]);
    exit;
}

$company_email = $_SESSION['email'];

$sql = "
SELECT 
    a.application_id,
    a.status,
    a.date_applied,
    s.full_name,
    s.skills,
    s.professional_summary,
    s.academic_year,
    s.portfolio_link,
    s.profile_image,
    s.resume,
    i.title AS internship_title,
    i.category
FROM Application a
JOIN Internship i ON a.internship_id = i.internship_id
JOIN Student s ON a.Semail = s.email
WHERE i.email = ?
ORDER BY a.date_applied DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $company_email);
$stmt->execute();
$result = $stmt->get_result();

$applicants = [];
while ($row = $result->fetch_assoc()) {
    $applicants[] = $row;
}

echo json_encode(["status" => "success", "data" => $applicants]);
