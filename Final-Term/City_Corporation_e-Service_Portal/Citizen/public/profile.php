<?php
session_start();

// 1. Security Check
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'citizen') {
    header("Location: ../../Home/public/index.php");
    exit();
}

require_once '../config/db.php';
require_once '../controllers/CitizenController.php';

// CRITICAL FIX: Changed $pdo to $conn (MySQLi)
$controller = new CitizenController($conn);

// 2. Handle Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $controller->updateProfile();
} else {
    $controller->showProfilePage(); 
}
?>