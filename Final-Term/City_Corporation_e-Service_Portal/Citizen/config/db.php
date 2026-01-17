<?php
// File: config/db.php

$host = 'localhost';
$db   = 'City_Corporation_e-Service_Portal'; // Ensure this matches your DB name exactly
$user = 'root'; 
$pass = ''; 

// 1. Create Connection (MySQLi Object-Oriented)
$conn = new mysqli($host, $user, $pass, $db);

// 2. Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. Set Charset (Important for special characters)
$conn->set_charset("utf8mb4");
?>