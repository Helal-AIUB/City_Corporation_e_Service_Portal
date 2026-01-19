<?php
require_once '../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        // Renamed to 'Users' to match your model
        $this->userModel = new Users($pdo);
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['signup'])) {
                $this->processSignup();
            }
            if (isset($_POST['signin'])) {
                $this->processSignin();
            }
            if (isset($_POST['forgot_password'])) {
                $this->processForgotPassword();
            }
            if (isset($_POST['reset_password'])) {
                $this->processResetPassword();
            }
        }
    }

    private function processSignup() {
        $name = $this->test_input($_POST["name"]);
        $email = $_POST["email"];
        $role = $_POST["role"] ?? ""; 
        $password = $_POST["password"];
        $confirm = $_POST["confirm_password"];

        // 1. Basic validation
        if (empty($name) || empty($email) || empty($role) || empty($password)) {
            echo "<script>alert('Please fill in all fields.');</script>";
            return;
        }

        // 2. Name validation (Your pattern)
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            echo "<script>alert('Only letters and white space allowed in Name');</script>";
            return;
        }

        // 3. Check if email already exists
        if ($this->userModel->findByEmail($email)) {
            echo "<script>alert('This email is already registered. Please use a different one or Sign In.');</script>";
            return;
        }

        // 4. Password match check
        if ($password !== $confirm) {
            echo "<script>alert('Passwords do not match!');</script>";
            return;
        }

        // 5. Register via Model
        if ($this->userModel->register($name, $email, $role, $password)) {
            echo "<script>alert('Registration Complete!');</script>";
        }
    }

//     private function processSignin() {
//         $email = trim($_POST['signin_email']);
//        $password = $_POST['signin_password'];

//     if (empty($email) || empty($password)) {
//         echo "<script>alert('Please fill in all login fields.');</script>";
//         return;
//     }

//     $user = $this->userModel->findByEmail($email);

//     if ($user && password_verify($password, $user['password'])) {
//         if (session_status() === PHP_SESSION_NONE) {
//             session_start();
//         }
        
//         // Store user data in session
//         $_SESSION['user_id'] = $user['id'];
//         $_SESSION['user_name'] = $user['name'];
//         $_SESSION['user_role'] = $user['role'];

//         // Redirect based on role
//         if ($user['role'] === 'citizen') {
//             header("Location: ../Citizen/public/index.php");
//             exit(); // Always use exit() after a header redirect
//         } else if ($user['role'] === 'official') {
//             header("Location: ../Official/public/index.php");
//             exit();
//         } else {
//             header("Location: ../Counselor/public/index.php");
//             exit();
//         }
//     } else {
//         echo "<script>alert('Invalid Email or Password');</script>";
//     }
// }

private function processSignin() {
        $email = trim($_POST['signin_email']);
        $password = $_POST['signin_password'];

        if (empty($email) || empty($password)) {
            echo "<script>alert('Please fill in all login fields.');</script>";
            return;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // JavaScript Redirect logic to avoid "Header already sent" errors
            $redirectPath = "";
            if ($user['role'] === 'citizen') {
                //$redirectPath = "../Citizen/public/index.php";
                $redirectPath = "../../Citizen/public/index.php";
            } else if ($user['role'] === 'official') {
                $redirectPath = "../../Official/public/index.php";
            } else {
                $redirectPath = "../../Counselor/public/index.php";
            }

            echo "<script>
                alert('Welcome back, " . $user['name'] . "!');
                window.location.href = '$redirectPath';
            </script>";
            exit(); 
        } else {
            echo "<script>alert('Invalid Email or Password');</script>";
        }
    }

    private function processForgotPassword() {
        $email = $_POST["email"];
        if (empty($email)) {
            echo "<script>alert('Please enter your email.');</script>";
            return;
        }

        $user = $this->userModel->findByEmail($email);
        if ($user) {
            $token = bin2hex(random_bytes(16));
            $token_hash = hash("sha256", $token);
            $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // 30 mins validity

            if ($this->userModel->saveResetToken($email, $token_hash, $expiry)) {
                // Construct the reset link
                // Assuming this is running on localhost/WT_Fall25-26/...
                $path = dirname($_SERVER['PHP_SELF']); 
                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . $path . "/reset_password.php?token=" . $token;
                
                // SIMULATION: In a real app, use mail() or PHPMailer here.
                echo "<script>
                    alert('Password reset link (Simulated): " . $resetLink . "');
                    window.location.href = 'index.php';
                </script>";
            }
        } else {
            echo "<script>alert('Email not found.');</script>";
        }
    }

    private function processResetPassword() {
        $token = $_POST["token"];
        $password = $_POST["password"];
        $confirm = $_POST["confirm_password"];

        if ($password !== $confirm) {
            echo "<script>alert('Passwords do not match.');</script>";
            return;
        }

        $token_hash = hash("sha256", $token);
        $user = $this->userModel->getUserByToken($token_hash);

        if ($user) {
            if (strtotime($user['reset_token_expires_at']) <= time()) {
                echo "<script>alert('Token has expired.');</script>";
                return;
            }

            if ($this->userModel->updatePassword($user['id'], $password)) {
                echo "<script>
                    alert('Password updated successfully. Please login.');
                    window.location.href = 'index.php';
                </script>";
            }
        } else {
            echo "<script>alert('Invalid or expired token.');</script>";
        }
    }

    private function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}
?>