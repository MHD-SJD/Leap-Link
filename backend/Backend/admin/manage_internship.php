<?php
require_once "../config/db.php";
require_once "../utils/auth_check.php";

$id = $_POST['internship_id'];

$sql = "DELETE FROM Internship WHERE internship_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Internship removed by admin";
} else {
    echo "Error";
}
?>
