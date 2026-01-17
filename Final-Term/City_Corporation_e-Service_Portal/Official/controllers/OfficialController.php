<?php
require_once '../models/OfficialModel.php';

class OfficialController {
    private $model;

    public function __construct($conn) {
        $this->model = new OfficialModel($conn);
    }

    public function showDashboard() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // 1. Fetch Stats
        $stats = $this->model->getStats();
        
        // 2. Fetch Trade Licenses
        $applications = $this->model->getAllTradeLicenses();

        // 3. Fetch NID Applications (Crucial for the view to work)
        $nidApplications = $this->model->getAllNidApplications();
        
        // 4. Load the View
        include '../views/dashboard.view.php';
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Handle Trade License Updates
            if (isset($_POST['update_status'])) {
                $id = $_POST['application_id'];
                $status = $_POST['status'];
                $this->model->updateTradeLicenseStatus($id, $status);
                header("Location: index.php");
                exit();
            }

            // Handle NID Updates
            if (isset($_POST['update_nid_status'])) {
                $id = $_POST['nid_id'];
                $status = $_POST['status'];
                $this->model->updateNidStatus($id, $status);
                header("Location: index.php");
                exit();
            }
        }
    }
}
?>