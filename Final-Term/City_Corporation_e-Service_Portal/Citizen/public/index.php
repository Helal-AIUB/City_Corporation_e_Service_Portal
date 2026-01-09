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

// This line loads the file you just created above
require_once '../config/db.php'; 
require_once '../controllers/CitizenController.php';

// Now $pdo exists and the error will disappear
$controller = new CitizenController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $controller->updateProfile();
} else {
    $controller->showDashboard();
}
?>