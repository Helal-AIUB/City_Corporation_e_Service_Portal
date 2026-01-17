<?php
// File: public/nid_correction.php
session_start();

// 1. Security Check
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'citizen') {
    header("Location: ../../Home/public/index.php");
    exit();
}

// 2. Include DB and Controller
require_once '../config/db.php';
require_once '../controllers/CitizenController.php';

// 3. Instantiate Controller with MySQLi $conn
// (This matches your new config/db.php setup)
$controller = new CitizenController($conn);

// 4. Route the Request
// Checks if the "apply_nid" button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_nid'])) {
    $controller->processNIDCorrection();
} else {
    $controller->showNIDForm();
}
?>