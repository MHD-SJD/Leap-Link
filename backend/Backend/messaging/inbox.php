<?php
require_once "../config/db.php";
require_once "../utils/auth_check.php";

$userId = $_SESSION['email'];
$userType = $_SESSION['role'];

$sql = "SELECT * FROM Message
        WHERE recipient_id = ? AND recipient_type = ?
        ORDER BY timestamp DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $userId, $userType);
$stmt->execute();

$result = $stmt->get_result();
$messages = [];

while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
