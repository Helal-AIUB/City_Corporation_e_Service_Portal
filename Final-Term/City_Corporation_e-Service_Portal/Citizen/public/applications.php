<?php
session_start();

// Security Check
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'citizen') {
    header("Location: ../../Home/public/index.php");
    exit();
}

require_once '../config/db.php';
require_once '../controllers/CitizenController.php';

// CRITICAL FIX: Changed $pdo to $conn (MySQLi)
$controller = new CitizenController($conn);

// Call the new function to show the list
$controller->showMyApplications();
?>