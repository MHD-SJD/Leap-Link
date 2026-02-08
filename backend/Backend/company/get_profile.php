<?php
session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

if (!isset($_SESSION['email'])) {
    echo json_encode(["status"=>"error","message"=>"Session expired"]);
    exit;
}

$email = $_SESSION['email'];
$webDir = "Backend/uploads/company_logos/";

$stmt = $conn->prepare("SELECT company_name, location, industry, website, description, logo FROM Company WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo json_encode([
        "status" => "success",
        "profile" => [
            "company_name" => $row['company_name'],
            "company_location" => $row['location'],
            "industry" => $row['industry'],
            "website" => $row['website'],
            "description" => $row['description'],
            "logo" => $row['logo'] ? $webDir . $row['logo'] : $webDir . "default-logo.png"
        ]
    ]);
}else{
    echo json_encode([
        "status" => "success",
        "profile" => [
            "company_name" => "",
            "company_location" => "",
            "industry" => "",
            "website" => "",
            "description" => "",
            "logo" => $webDir . "default-logo.png"
        ]
    ]);
}
?>
