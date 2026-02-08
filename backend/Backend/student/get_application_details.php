<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$studentEmail = $_SESSION['email'];
$internshipId = intval($_GET['internship_id'] ?? 0);

if ($internshipId === 0) {
    echo json_encode(["status" => "error", "message" => "Invalid internship ID"]);
    exit;
}

$sql = "
SELECT 
    i.title,
    i.description,
    i.requirements,
    i.location,
    c.company_name,
    c.email,
    c.logo
FROM Application a
JOIN Internship i ON a.internship_id = i.internship_id
JOIN Company c ON i.email = c.email
WHERE a.Semail = ? AND i.internship_id = ?
LIMIT 1
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "SQL prepare failed: ".$conn->error]);
    exit;
}

$stmt->bind_param("si", $studentEmail, $internshipId);
if (!$stmt->execute()) {
    echo json_encode(["status" => "error", "message" => "SQL execute failed: ".$stmt->error]);
    exit;
}

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "No application found for this internship"]);
    exit;
}

$data = $result->fetch_assoc();

// ---- FIX: Make logo path web-accessible ----
// If logo is empty, use default
$defaultLogo = "Backend/uploads/company_logos/default-logo.png"; // relative to your web root
if (!empty($data['logo'])) {
    // Ensure it's a relative web path
    $data['logo'] = "Backend/uploads/company_logos/" . basename($data['logo']);
} else {
    $data['logo'] = $defaultLogo;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
exit;
