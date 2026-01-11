<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Bills | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .bill-card { background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-left: 5px solid #e74c3c; display: flex; justify-content: space-between; align-items: center; }
        .bill-info h4 { margin-bottom: 5px; color: #2c3e50; }
        .bill-amount { font-size: 20px; font-weight: bold; color: #e74c3c; }
        
        /* Payment Form inside the card */
        .pay-form { display: flex; gap: 10px; align-items: center; background: #f9f9f9; padding: 10px; border-radius: 8px; }
        .pay-form select, .pay-form input { padding: 8px; border: 1px solid #ddd; border-radius: 5px; outline: none; }
        .btn-pay { background: #27ae60; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-pay:hover { background: #219150; }
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
                <li><a href="applications.php"><i class="fa fa-file-alt"></i> My Applications</a></li>
                <li class="active"><a href="billing.php"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Pay Bills</h1>
                <p>Clear your due payments to get services approved.</p>
            </header>

            <?php if (empty($bills)): ?>
                <div style="text-align:center; padding: 50px; background:white; border-radius:12px;">
                    <i class="fa fa-check-circle" style="font-size: 50px; color: #2ecc71; margin-bottom: 20px;"></i>
                    <h3>No Pending Bills!</h3>
                    <p style="color:#777;">You have paid all your dues.</p>
                </div>
            <?php else: ?>
                <?php foreach ($bills as $bill): ?>
                <div class="bill-card">
                    <div class="bill-info">
                        <h4>Trade License Fee</h4>
                        <p>Business: <strong><?php echo $bill['business_name']; ?></strong></p>
                        <small>Applied: <?php echo date("d M Y", strtotime($bill['applied_at'])); ?></small>
                    </div>
                    
                    <div style="text-align:right;">
                        <div class="bill-amount"><?php echo $bill['fee_amount']; ?> BDT</div>
                        <small style="color:#e74c3c;">Unpaid</small>
                    </div>

                    <form action="billing.php" method="POST" class="pay-form">
                        <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
                        
                        <select name="payment_method" required>
                            <option value="" disabled selected>Method</option>
                            <option value="Bkash">Bkash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                        </select>
                        
                        <input type="text" name="trx_id" placeholder="Trx ID" required style="width: 100px;">
                        
                        <button type="submit" name="pay_bill" class="btn-pay">Pay Now</button>
                    </form>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </main>
    </div>
</body>
</html>