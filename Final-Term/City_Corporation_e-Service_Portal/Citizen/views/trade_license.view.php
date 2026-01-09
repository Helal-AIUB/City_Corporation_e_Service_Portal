<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Trade License | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .form-section { background: white; padding: 30px; border-radius: 12px; max-width: 800px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .form-header { margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .form-header h2 { color: #2da0a8; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; }
        .readonly-field { background-color: #f9f9f9; color: #777; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <nav class="sidebar">
            <div class="brand"><h2><i class="fa fa-building"></i> CityCorp</h2></div>
            <div class="user-profile-preview">
                <img src="uploads/<?php echo $user['profile_pic'] ?? 'default.png'; ?>" alt="Profile">
                <div><h4><?php echo $_SESSION['user_name']; ?></h4><small>Citizen</small></div>
            </div>
            <ul class="menu">
                <li><a href="index.php"><i class="fa fa-th-large"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="fa fa-user-cog"></i> My Profile</a></li>
                <li class="active"><a href="#"><i class="fa fa-file-alt"></i> Apply Service</a></li>
                <li><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="form-section">
                <div class="form-header">
                    <h2><i class="fa fa-file-contract"></i> New Trade License Application</h2>
                    <p>Please ensure your profile info is correct before applying.</p>
                </div>

                <form action="apply_trade.php" method="POST">
                    
                    <h4 style="margin-bottom:15px; color:#2c3e50;">Applicant Details</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Applicant Name</label>
                            <input type="text" value="<?php echo $user['name']; ?>" class="readonly-field" readonly>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" value="<?php echo $user['phone']; ?>" class="readonly-field" readonly>
                        </div>
                        <div class="form-group">
                            <label>NID Number</label>
                            <input type="text" value="<?php echo $user['nid']; ?>" class="readonly-field" readonly>
                        </div>
                    </div>

                    <hr style="border:0; border-top:1px solid #eee; margin: 20px 0;">

                    <h4 style="margin-bottom:15px; color:#2c3e50;">Business Details</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Business Name</label>
                            <input type="text" name="business_name" placeholder="e.g. Dhaka General Store" required>
                        </div>
                        <div class="form-group">
                            <label>Business Type</label>
                            <select name="business_type" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="Proprietorship">Proprietorship</option>
                                <option value="Partnership">Partnership</option>
                                <option value="Limited Company">Limited Company</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Trade Capital (BDT)</label>
                            <input type="number" name="trade_capital" placeholder="e.g. 500000" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 25px;">
                        <label>Business Address</label>
                        <textarea name="business_address" rows="3" placeholder="Full address of the business location" required></textarea>
                    </div>

                    <button type="submit" name="submit_application" class="btn-apply" style="background:#2da0a8; color:white; width: 100%; padding: 15px; font-size: 16px;">Submit Application</button>
                </form>
            </div>
        </main>
    </div>

    <hr style="border:0; border-top:1px solid #eee; margin: 20px 0;">

    <h4 style="margin-bottom:15px; color:#2c3e50;">Application Fee Payment</h4>
    <div style="background: #e8f5e9; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c8e6c9;">
        <p style="margin-bottom: 10px; color: #2e7d32; font-weight: bold;">
            <i class="fa fa-money-bill-wave"></i> Application Fee: 500 BDT
        </p>
        
        <div class="form-grid">
            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="" disabled selected>Select Method</option>
                    <option value="Bkash">Bkash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Rocket">Rocket</option>
                    <option value="Bank Draft">Bank Draft</option>
                </select>
            </div>
            <div class="form-group">
                <label>Transaction ID (TrxID)</label>
                <input type="text" name="trx_id" placeholder="e.g. 8JHS672K" required>
                <small style="color:#666;">(For this demo, just type any random ID)</small>
            </div>
        </div>
    </div>

    <button type="submit" name="submit_application" class="btn-apply" style="background:#2da0a8; color:white; width: 100%; padding: 15px; font-size: 16px; font-weight:bold; border:none; border-radius:8px; cursor:pointer;">
        Submit Application & Pay
    </button>
</form>
</body>
</html>