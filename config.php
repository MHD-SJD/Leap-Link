<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "leaplink";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
   die("Connection faild: " .$conn->connect_error);
}

?>