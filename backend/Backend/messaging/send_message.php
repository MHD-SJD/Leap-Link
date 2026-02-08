<?php
require_once "../config/db.php";
require_once "../utils/auth_check.php";

$senderType = $_SESSION['role']; // Student or Company
$senderId = $_SESSION['email'];

$recipientId = $_POST['recipient_id'];
$recipientType = $_POST['recipient_type'];
$content = $_POST['content'];

$sql = "INSERT INTO Message 
(sender_id, recipient_id, sender_type, recipient_type, content)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $senderId, $recipientId, $senderType, $recipientType, $content);

if ($stmt->execute()) {
    echo "Message sent";
} else {
    echo "Error sending message";
}
?>
