<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

session_start(); // ✅ Start session

require_once "../config/db.php";

/* ---------------- CHECK SESSION ---------------- */
if (!isset($_SESSION['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired. Please login again."
    ]);
    exit;
}

$company_email = $_SESSION['email'];

/* ---------------- FETCH INTERNSHIPS ---------------- */
$sql= "SELECT 
    i.internship_id,
    i.title,
    i.location,
    i.category,
    i.date_posted,
    (
        SELECT COUNT(*) 
        FROM Application a 
        WHERE a.internship_id = i.internship_id
    ) AS total_applications
FROM Internship i
WHERE i.email = ?
ORDER BY i.date_posted DESC";


$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("s", $company_email);

if (!$stmt->execute()) {
    echo json_encode([
        "status" => "error",
        "message" => "Execute failed: " . $stmt->error
    ]);
    exit;
}

$result = $stmt->get_result();
$internships = [];

while ($row = $result->fetch_assoc()) {
    $internships[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode([
    "status" => "success",
    "data" => $internships
]);
