<?php
require_once "../config/db.php";
require_once "../utils/auth_check.php";

header("Content-Type: application/json");

if (!isset($_POST['application_id'])) {
    echo json_encode(["status" => "error", "message" => "Missing ID"]);
    exit;
}

$appId = intval($_POST['application_id']);

$stmt = $conn->prepare(
    "UPDATE Application 
     SET status = 'Interviewing' 
     WHERE application_id = ?"
);
$stmt->bind_param("i", $appId);

if ($stmt->execute()) {
    echo json_encode(["status" => "selected"]);
} else {
    echo json_encode(["status" => "error"]);
}
