<?php
session_start();

// --- START: PREVENT BROWSER CACHING ---
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// --- END: PREVENT BROWSER CACHING ---

// Protection Logic
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'citizen') {
    header("Location: ../../Home/public/index.php");
    exit();
}

// 1. Load the Database Configuration
// This file now provides a variable named '$conn' (MySQLi), NOT '$pdo'
require_once '../config/db.php'; 

require_once '../controllers/CitizenController.php';

// 2. Instantiate the Controller
// CRITICAL FIX: Changed $pdo to $conn
$controller = new CitizenController($conn);

// 3. Handle Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $controller->updateProfile();
} else {
    $controller->showDashboard();
}
?>