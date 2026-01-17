<?php
// File: Official/public/index.php
session_start();

// 1. Security Check
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'official') {
    // If not logged in as official, redirect to Home
    header("Location: ../../Home/public/index.php");
    exit();
}

// 2. Load Database & Controller
// This loads the file you just fixed in Step 1
require_once '../config/db.php'; 
require_once '../controllers/OfficialController.php';

// 3. Initialize Controller
// Now $conn will exist!
$controller = new OfficialController($conn);

// 4. Handle Requests
$controller->handleRequest();
$controller->showDashboard();
?>