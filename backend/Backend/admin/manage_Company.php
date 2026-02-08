<?php
require_once "../config/db.php";

$sql = "
SELECT 
    c.email,
    c.company_name,
    COUNT(DISTINCT i.internship_id) AS total_posts,
    COUNT(a.application_id) AS total_applications
FROM Company c
LEFT JOIN Internship i 
    ON c.email = i.email
LEFT JOIN Application a 
    ON i.internship_id = a.internship_id
GROUP BY c.email
ORDER BY c.created_at DESC
";

$result = $conn->query($sql);

$companies = [];

while ($row = $result->fetch_assoc()) {
    $companies[] = $row;
}

header('Content-Type: application/json');
echo json_encode($companies);
?>
