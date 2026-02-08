<?php
require_once "../config/db.php";

header("Content-Type: application/json");

$q = trim($_GET['q'] ?? "");

/*
  SALES CATEGORY ONLY
  Assumption:
  - Internship.category = 'Sales'
*/

$sql = "
SELECT 
    i.internship_id,
    i.title,
    i.description,
    i.location_type,
    i.duration,
    i.salary,
    c.company_name,
    c.company_location,
    c.company_email,
    c.logo
FROM Internship i
JOIN Company c ON i.email = c.email
WHERE i.category = 'sales'
";

$params = [];
$types  = "";

/* SEARCH FILTER */
if ($q !== "") {
    $sql .= " AND (i.title LIKE ? OR c.company_name LIKE ?)";
    $like = "%$q%";
    $params = [$like, $like];
    $types = "ss";
}

$sql .= " ORDER BY i.date_posted DESC LIMIT 8";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

echo json_encode($jobs);
