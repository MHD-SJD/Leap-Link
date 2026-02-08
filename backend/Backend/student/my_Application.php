<?php
session_start();
header("Content-Type: application/json");
require_once "../config/db.php";

if (!isset($_SESSION['email'])) {
    echo json_encode([]);
    exit;
}

$studentEmail = $_SESSION['email'];

$sql = "
SELECT 
    a.status,
    a.date_applied,
    i.internship_id,
    i.title,
    c.company_name
FROM Application a
JOIN Internship i ON a.internship_id = i.internship_id
JOIN Company c ON i.email = c.email
WHERE a.Semail = ?
ORDER BY a.date_applied DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentEmail);
$stmt->execute();
$result = $stmt->get_result();

$apps = [];
while ($row = $result->fetch_assoc()) {
    $apps[] = $row;
}

echo json_encode($apps);
