<?php
// File: controllers/CitizenController.php
require_once '../models/CitizenModel.php';

class CitizenController {
    private $model;

    public function __construct($conn) {
        $this->model = new CitizenModel($conn);
    }

    // =========================================================
    // 1. DASHBOARD & PROFILE
    // =========================================================

    public function showDashboard() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId);
        include '../views/dashboard.view.php';
    }

    public function showProfilePage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId); 
        include '../views/profile.view.php';
    }

    public function updateProfile() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $nid = $_POST['nid'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            $profilePic = null;
            if (!empty($_FILES['profile_pic']['name'])) {
                $targetDir = "../public/uploads/";
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
                $fileName = time() . "_" . basename($_FILES["profile_pic"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)) {
                    $profilePic = $fileName;
                }
            }

            if ($this->model->updateInfo($userId, $nid, $phone, $address, $profilePic)) {
                echo "<script>alert('Profile Updated Successfully!'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Update Failed');</script>";
            }
        }
    }

    // =========================================================
    // 2. TRADE LICENSE
    // =========================================================

    public function showTradeLicenseForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId);
        
        if (empty($user['nid']) || empty($user['phone']) || empty($user['address'])) {
            echo "<script>alert('⚠️ Please complete your profile first!'); window.location.href = 'profile.php';</script>";
            exit(); 
        }
        include '../views/trade_license.view.php';
    }

    // UPDATED: No longer takes payment info. Just saves and redirects to BILLING.
    public function processTradeLicense() { 
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $businessName = $_POST['business_name'];
        $businessType = $_POST['business_type'];
        $businessAddress = $_POST['business_address'];
        $capital = $_POST['trade_capital'];

        if ($this->model->createTradeLicense($userId, $businessName, $businessType, $businessAddress, $capital)) {
             echo "<script>
                    alert('Application Submitted! Please pay the fee from the Billing section.'); 
                    window.location.href = 'billing.php'; 
                   </script>";
        } else {
            echo "<script>alert('Application Failed.');</script>";
        }
    }

    public function showMyApplications() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId); 
        $tradeLicenses = $this->model->getMyTradeLicenses($userId);
        $nidApplications = $this->model->getMyNidApplications($userId);
        // --- NEW LINE: Fetch Water Apps ---
        $waterApplications = $this->model->getAllWaterApplications($userId);
        include '../views/applications.view.php';
    }

    // =========================================================
    // 3. NID CORRECTION
    // =========================================================

    public function showNIDForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId);
        include '../views/nid_correction.view.php'; 
    }

    public function processNIDCorrection() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $currentNid = $_POST['current_nid'];
            $correctionType = $_POST['correction_type'];
            $details = $_POST['details'];

            if ($this->model->createNidCorrection($userId, $currentNid, $correctionType, $details)) {
                echo "<script>
                        alert('Application Submitted! Please pay the fee.');
                        window.location.href = 'billing.php'; 
                      </script>";
            } else {
                echo "<script>alert('Application Failed.'); window.history.back();</script>";
            }
        }
    }

    // =========================================================
    // 4. BILLING CONTROLLER (NEW)
    // =========================================================

    public function showBillingPage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId);
        
        // Fetch all unpaid bills
        $unpaidBills = $this->model->getUnpaidBills($userId);
        
        include '../views/billing.view.php';
    }

    public function processBillPayment() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serviceType = $_POST['service_type'];
            $billId = $_POST['bill_id'];
            $paymentMethod = $_POST['payment_method'];
            $trxId = $_POST['trx_id'];

            if ($this->model->processPayment($serviceType, $billId, $paymentMethod, $trxId)) {
                 echo "<script>
                        alert('Payment Successful! The authorities will review your application.');
                        window.location.href = 'applications.php';
                       </script>";
            } else {
                 echo "<script>alert('Payment Failed. Please try again.'); window.history.back();</script>";
            }
        }
    }

    // --- WATER CONNECTION CONTROLLER ---

    public function showWaterForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId);
        include '../views/water_connection.view.php';
    }

    public function processWaterApplication() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            
            $type = $_POST['connection_type'];
            $holding = $_POST['holding_no'];
            $zone = $_POST['zone'];
            $pipe = $_POST['pipe_size'];
            $address = $_POST['address'];

            // LOGIC: Set Fee based on Type
            $fee = ($type === 'Commercial') ? 5000.00 : 2000.00;

            if ($this->model->createWaterConnection($userId, $type, $holding, $zone, $pipe, $address, $fee)) {
                 echo "<script>
                        alert('Water Connection Application Submitted! Fee: " . $fee . " BDT. Please pay in Billing.');
                        window.location.href = 'billing.php'; 
                       </script>";
            } else {
                echo "<script>alert('Application Failed.'); window.history.back();</script>";
            }
        }
    }
}
?>