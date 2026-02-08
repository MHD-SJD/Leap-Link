<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: ../loginform.php");
    exit();
}
?>
