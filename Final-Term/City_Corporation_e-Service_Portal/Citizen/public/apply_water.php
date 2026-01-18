<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'citizen') {
    header("Location: ../../Home/public/index.php");
    exit();
}

require_once '../config/db.php';
require_once '../controllers/CitizenController.php';

$controller = new CitizenController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_water'])) {
    $controller->processWaterApplication();
} else {
    $controller->showWaterForm();
}
?>