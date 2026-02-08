<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");
session_start();

require_once "../config/db.php";

/* ---------- CHECK SESSION ---------- */
if (!isset($_SESSION['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session expired"
    ]);
    exit;
}

$company_email = $_SESSION['email'];

/* ---------- INPUT ---------- */
$internship_id = $_POST['internship_id'] ?? '';

if (!$internship_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid internship ID"
    ]);
    exit;
}

/* ---------- DELETE QUERY ---------- */
$sql = "DELETE FROM Internship
        WHERE internship_id = ?
          AND email = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Prepare failed: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("is", $internship_id, $company_email);

/* ---------- EXECUTE ---------- */
if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "deleted"]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Not authorized or already deleted"
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "Execute failed: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
exit;
