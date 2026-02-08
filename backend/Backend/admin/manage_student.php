<?php
require_once "../config/db.php";

$sql = "
SELECT 
    s.email,
    s.full_name,
    s.academic_year,
    s.field,
    COUNT(a.application_id) AS total_applications
FROM Student s
LEFT JOIN Application a 
    ON s.email = a.Semail
GROUP BY s.email
ORDER BY s.created_at DESC
";

$result = $conn->query($sql);

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);
?>
