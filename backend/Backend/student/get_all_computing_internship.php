<?php
session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

$sql = "SELECT 
            i.internship_id,
            i.title,
            i.description,
            i.requirements,
            i.duration,
            i.salary,
            i.location,
            i.deadline,
            i.category,
            c.company_name,
            c.email AS company_email,
            c.location AS company_location,
            c.logo
        FROM Internship i
        JOIN Company c ON i.email = c.email
        WHERE LOWER(i.category) = 'computing'
        ORDER BY i.date_posted DESC";

$result = $conn->query($sql);
$jobs = [];

while ($row = $result->fetch_assoc()) {

    // Location type
    $loc = strtolower($row['location']);
    $row['location_type'] = str_contains($loc, 'remote') ? 'Remote' : 'On-Site';

    // Logo handling
    $row['logo'] = !empty($row['logo'])
        ? "Backend/uploads/company_logos/" . $row['logo']
        : "Backend/uploads/company/default-company.png";

    $jobs[] = $row;
}

echo json_encode($jobs);
