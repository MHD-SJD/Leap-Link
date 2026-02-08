<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: application/json");

require_once "../config/db.php";

$data = json_decode(file_get_contents("php://input"), true);

$application_id = $data['application_id'];
$status = $data['status'];

$sql = "UPDATE Application SET status = ? WHERE application_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $application_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
