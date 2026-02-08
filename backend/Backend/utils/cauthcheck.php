<?php
session_start();

/*
 You are logging in using USERS table.
 That means email is stored as `email`, NOT `company_email`
*/

if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(["status" => "unauthorized"]);
    exit;
}

/* 🔥 THIS LINE FIXES EVERYTHING */
$company_email = $_SESSION['email'];
