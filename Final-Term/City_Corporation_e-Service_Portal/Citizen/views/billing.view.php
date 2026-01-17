<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Bills | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .bill-card { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #e74c3c; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .bill-info h4 { margin: 0 0 5px 0; color: #2c3e50; }
        .bill-info p { margin: 0; color: #7f8c8d; font-size: 14px; }
        .bill-amount { font-size: 18px; font-weight: bold; color: #e74c3c; margin-right: 20px; }
        .payment-form { display: flex; gap: 10px; align-items: center; margin-top: 10px; }
        .payment-form input, .payment-form select { padding: 8px; border: 1px solid #ddd; border-radius: 5px; }
        .btn-pay { background: #27ae60; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-pay:hover { background: #219150; }
        .no-bills { text-align: center; padding: 40px; color: #95a5a6; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <nav class="sidebar">
            <div class="brand"><h2><i class="fa fa-building"></i> CityCorp</h2></div>
            <div class="user-profile-preview">
                <img src="uploads/<?php echo !empty($user['profile_pic']) ? $user['profile_pic'] : 'default.png'; ?>" alt="Profile">
                <div><h4><?php echo $_SESSION['user_name']; ?></h4><small>Citizen</small></div>
            </div>
            <ul class="menu">
                <li><a href="index.php"><i class="fa fa-th-large"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="fa fa-user-cog"></i> My Profile</a></li>
                <li><a href="applications.php"><i class="fa fa-file-alt"></i> My Applications</a></li>
                <li class="active"><a href="billing.php"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <h2 style="color:#2c3e50; border-bottom:1px solid #ddd; padding-bottom:15px; margin-bottom:20px;">
                <i class="fa fa-file-invoice-dollar"></i> Pending Bills
            </h2>

            <?php if (empty($unpaidBills)): ?>
                <div class="no-bills">
                    <i class="fa fa-check-circle" style="font-size: 50px; color: #2ecc71; margin-bottom: 15px;"></i>
                    <h3>All clear!</h3>
                    <p>You have no pending bills at the moment.</p>
                </div>
            <?php else: ?>
                
                <?php foreach ($unpaidBills as $bill): ?>
                    <div class="bill-card">
                        <div class="bill-info">
                            <h4><?php echo htmlspecialchars($bill['service_type']); ?> Fee</h4>
                            <p>Applied on: <?php echo date('d M, Y', strtotime($bill['applied_at'])); ?></p>
                        </div>
                        
                        <div style="display:flex; align-items:center;">
                            <span class="bill-amount"><?php echo number_format($bill['fee_amount'], 2); ?> BDT</span>
                            
                            <form action="billing.php" method="POST" class="payment-form">
                                <input type="hidden" name="service_type" value="<?php echo $bill['service_type']; ?>">
                                <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
                                
                                <select name="payment_method" required>
                                    <option value="" disabled selected>Method</option>
                                    <option value="Bkash">Bkash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Rocket">Rocket</option>
                                </select>
                                
                                <input type="text" name="trx_id" placeholder="Enter TrxID" required>
                                
                                <button type="submit" name="pay_bill" class="btn-pay">
                                    Pay Now
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </main>
    </div>
</body>
</html>