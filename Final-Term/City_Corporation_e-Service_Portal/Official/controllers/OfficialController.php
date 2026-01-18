<?php
require_once '../models/OfficialModel.php';

class OfficialController {
    private $model;

    public function __construct($conn) {
        $this->model = new OfficialModel($conn);
    }

    public function showDashboard() {
        // 1. Get Stats
        $stats = $this->model->getStats();
        
        // 2. Get All Lists
        $applications = $this->model->getAllTradeLicenses();
        $nidApplications = $this->model->getAllNidApplications();
        
        // --- NEW LINE: Get Water Connections ---
        $waterApplications = $this->model->getAllWaterConnections(); 

        // 3. Load View
        require_once '../views/dashboard.view.php';
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

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_water_status'])) {
            $id = $_POST['water_id'];
            $status = $_POST['update_water_status']; // 'approved' or 'rejected'
            
            if ($this->model->updateWaterStatus($id, $status)) {
                // Refresh page to show changes
                header("Location: index.php");
                exit();
            } else {
                echo "Error updating status.";
            }
        }
        }
    }
}
?>