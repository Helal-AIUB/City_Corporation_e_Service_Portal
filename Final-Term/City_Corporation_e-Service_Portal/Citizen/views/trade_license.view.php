<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Trade License | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .form-section { background: white; padding: 30px; border-radius: 12px; max-width: 800px; margin: 20px auto; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; }
        .btn-submit { background: #e67e22; color: white; width: 100%; padding: 15px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .btn-submit:hover { background: #d35400; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <nav class="sidebar">
            <div class="brand">
                <h2><i class="fa fa-building"></i> CityCorp</h2>
            </div>
            <div class="user-profile-preview">
                <img src="uploads/<?php echo !empty($user['profile_pic']) ? $user['profile_pic'] : 'default.png'; ?>" alt="Profile">
                <div>
                    <h4><?php echo $_SESSION['user_name'] ?? 'Citizen'; ?></h4>
                    <small>Citizen</small>
                </div>
            </div>
            <ul class="menu">
                <li><a href="index.php"><i class="fa fa-th-large"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="fa fa-user-cog"></i> My Profile</a></li>
                <li><a href="applications.php"><i class="fa fa-file-alt"></i> My Applications</a></li>
                <li><a href="billing.php"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="form-section">
                <h2 style="color:#e67e22; border-bottom:1px solid #eee; padding-bottom:15px; margin-bottom:25px;">
                    <i class="fa fa-file-contract"></i> New Trade License Application
                </h2>

                <form action="" method="POST">
                    
                    <div class="form-group">
                        <label>Business Name</label>
                        <input type="text" name="business_name" placeholder="e.g. Dhaka General Store" required>
                    </div>

                    <div class="form-group">
                        <label>Business Type</label>
                        <select name="business_type" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Retail">Retail</option>
                            <option value="Wholesale">Wholesale</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="IT Services">IT Services</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Trade Capital (BDT)</label>
                        <input type="number" name="trade_capital" placeholder="e.g. 500000" required>
                    </div>

                    <div class="form-group">
                        <label>Business Address</label>
                        <textarea name="business_address" rows="3" placeholder="Full address of the business location" required></textarea>
                    </div>

                    <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                        <i class="fa fa-info-circle"></i> <strong>Note:</strong> 
                        Application Fee is <strong>500 BDT</strong>. You will be asked to pay this from the "Pay Bills" section after submitting.
                    </div>

                    <button type="submit" name="submit_application" class="btn-submit">Submit Application</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>