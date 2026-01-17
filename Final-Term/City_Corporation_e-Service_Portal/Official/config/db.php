<?php
// File: Official/config/db.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "City_Corporation_e-Service_Portal"; // Make sure this matches your actual database name

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>