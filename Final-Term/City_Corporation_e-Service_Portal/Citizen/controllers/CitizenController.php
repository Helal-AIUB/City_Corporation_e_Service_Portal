<?php
require_once '../models/CitizenModel.php';

class CitizenController {
    private $model;

    public function __construct($pdo) {
        $this->model = new CitizenModel($pdo);
    }

    // 1. Load the Dashboard View with User Data
    public function showDashboard() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId); // Fetch current data
        
        // Pass data to the view
        include '../views/dashboard.view.php';
    }

    public function showProfilePage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userId = $_SESSION['user_id'];
        $user = $this->model->getProfile($userId); // Reusing your existing model method
        
        include '../views/profile.view.php';
    }

    // 2. Handle Profile Updates (POST request)
    public function updateProfile() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $nid = $_POST['nid'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            
            // Handle File Upload (Profile Picture)
            $profilePic = null;
            if (!empty($_FILES['profile_pic']['name'])) {
                $targetDir = "../public/uploads/";
                
                // Create folder if it doesn't exist
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                $fileName = time() . "_" . basename($_FILES["profile_pic"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)) {
                    $profilePic = $fileName;
                }
            }

            // Save to Database
            if ($this->model->updateInfo($userId, $nid, $phone, $address, $profilePic)) {
                echo "<script>
                        alert('Profile Updated Successfully!');
                        window.location.href = 'index.php';
                      </script>";
            } else {
                echo "<script>alert('Update Failed');</script>";
            }
        }
    }


    // --- TRADE LICENSE FUNCTIONS ---

   public function showTradeLicenseForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];
        
        // 1. Fetch current user data
        $user = $this->model->getProfile($userId);
        
        // 2. CHECK: Is the profile complete?
        // We check if NID, Phone, or Address are empty or null
        if (empty($user['nid']) || empty($user['phone']) || empty($user['address'])) {
            
            // 3. If incomplete: Show Alert & Redirect to Profile Page
            echo "<script>
                    alert('⚠️ Action Required! \\n\\nYou must complete your Profile Information (NID, Phone Number, and Address) before applying for a Trade License.');
                    window.location.href = 'profile.php';
                  </script>";
            exit(); // Stop the script here
        }

        // 4. If complete: Show the Application Form
        include '../views/trade_license.view.php';
    }

    public function processTradeLicense() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userId = $_SESSION['user_id'];
        $businessName = $_POST['business_name'];
        $businessType = $_POST['business_type'];
        $businessAddress = $_POST['business_address'];
        $capital = $_POST['trade_capital'];

        if ($this->model->createTradeLicense($userId, $businessName, $businessType, $businessAddress, $capital)) {
             echo "<script>
                    alert('Application Submitted Successfully!');
                    window.location.href = 'index.php'; // Redirect to dashboard
                  </script>";
        } else {
            echo "<script>alert('Application Failed. Please try again.');</script>";
        }
    }
    // Inside CitizenController.php

    public function processTradeLicense2() { // Your renamed function
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userId = $_SESSION['user_id'];
        $businessName = $_POST['business_name'];
        $businessType = $_POST['business_type'];
        $businessAddress = $_POST['business_address'];
        $capital = $_POST['trade_capital'];
        
        // Ensure these NEW payment variables are here
        $paymentMethod = $_POST['payment_method'];
        $trxId = $_POST['trx_id'];
        $fee = 500.00; 

        // Make sure your Model function accepts these extra arguments!
        // If you didn't rename the model function, this line is fine:
        if ($this->model->createTradeLicense($userId, $businessName, $businessType, $businessAddress, $capital, $paymentMethod, $trxId, $fee)) {
             echo "<script>
                    alert('Application & Payment Submitted Successfully!');
                    window.location.href = 'index.php'; 
                  </script>";
        } else {
            echo "<script>alert('Application Failed. Please try again.');</script>";
        }
    }
    // --- MY APPLICATIONS PAGE ---
    public function showMyApplications() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user_id'];

        $user = $this->model->getProfile($userId); //set user profile pic
        
        // Fetch all applications for this user
        $tradeLicenses = $this->model->getMyTradeLicenses($userId);
        
        include '../views/applications.view.php';
    }
}
?>