<?php
header("Content-Type: application/json");
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['email'])) {
    echo json_encode(["status" => "error"]);
    exit;
}

$id = $_GET['id'] ?? '';
$email = $_SESSION['email'];

$stmt = $conn->prepare(
  "SELECT * FROM Internship WHERE internship_id = ? AND email = ?"
);
$stmt->bind_param("is", $id, $email);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode(["status" => "success", "data" => $data]);

$stmt->close();
$conn->close();
