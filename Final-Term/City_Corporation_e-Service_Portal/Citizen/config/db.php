<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "City_Corporation_e-Service_Portal"; // Make sure this matches your database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Error: " . $e->getMessage());
}
?>