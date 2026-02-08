<?php
require_once "../config/db.php";
require_once "../utils/cauthcheck.php"; // Make sure $company_email is set

header("Content-Type: application/json");

/* ============ TOTAL INTERNSHIPS ============ */
$stmt = $conn->prepare(
    "SELECT COUNT(*) FROM Internship WHERE email = ?"
);
$stmt->bind_param("s", $company_email);
$stmt->execute();
$stmt->bind_result($totalInternships);
$stmt->fetch();
$stmt->close();

/* ============ TOTAL APPLICATIONS ============ */
$stmt = $conn->prepare(
    "SELECT COUNT(*) 
     FROM Application a
     JOIN Internship i ON a.internship_id = i.internship_id
     WHERE i.email = ?"
);
$stmt->bind_param("s", $company_email);
$stmt->execute();
$stmt->bind_result($totalApplications);
$stmt->fetch();
$stmt->close();

/* ============ APPLICATION PIPELINE ============ */
$pipeline = [
    "Pending" => 0,
    "Reviewed" => 0,
    "Interviewing" => 0,
    "Hired" => 0,
    "Rejected" => 0
];

$stmt = $conn->prepare(
    "SELECT a.status, COUNT(*) AS total
     FROM Application a
     JOIN Internship i ON a.internship_id = i.internship_id
     WHERE i.email = ?
     GROUP BY a.status"
);
$stmt->bind_param("s", $company_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $pipeline[$row['status']] = (int)$row['total'];
}
$stmt->close();

/* ============ APPLICATIONS OVER TIME (LINE CHART) ============ */
$lineChart = [];
$stmt = $conn->prepare(
    "SELECT DATE(a.date_applied) AS applied_date, COUNT(*) AS total
     FROM Application a
     JOIN Internship i ON a.internship_id = i.internship_id
     WHERE i.email = ?
     GROUP BY DATE(a.date_applied)
     ORDER BY applied_date ASC"
);
$stmt->bind_param("s", $company_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $lineChart[] = [
        "date" => $row['applied_date'],
        "total" => (int)$row['total']
    ];
}
$stmt->close();

/* ============ RESPONSE ============ */
echo json_encode([
    "internships" => (int)$totalInternships,
    "applications" => (int)$totalApplications,
    "pipeline" => $pipeline,
    "lineChart" => $lineChart
]);
