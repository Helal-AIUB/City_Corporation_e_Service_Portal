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

// 1. Handle Payment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_bill'])) {
    // Make sure this function exists in your controller!
    $controller->processBillPayment();
} 
// 2. Show the Bill List
else {
    // Make sure this function exists in your controller!
    $controller->showBillingPage();
}
?>