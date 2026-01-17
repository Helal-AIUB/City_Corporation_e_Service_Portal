<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Table Styling */
        .table-container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .section-title { color: #2c3e50; margin-bottom: 15px; border-left: 5px solid #3498db; padding-left: 10px; font-size: 18px; }
        
        .app-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .app-table th, .app-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        .app-table th { background-color: #f8f9fa; color: #555; font-weight: 600; font-size: 14px; text-transform: uppercase; }
        .app-table tr:hover { background-color: #fcfcfc; }

        /* Status Badges */
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }

        /* NEW: Download Button Style */
        .btn-download {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
            padding: 5px 10px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-download:hover {
            background-color: #219150;
        }
        
        /* Payment Text */
        .pay-success { color: #27ae60; font-weight: bold; font-size: 13px; }
        .pay-pending { color: #e74c3c; font-weight: bold; font-size: 13px; }
        .trx-info { font-size: 11px; color: #7f8c8d; display: block; margin-top: 2px; }
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
                <li class="active"><a href="applications.php"><i class="fa fa-file-alt"></i> My Applications</a></li>
                <li><a href="billing.php"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <h2 style="color:#2c3e50; border-bottom:1px solid #ddd; padding-bottom:15px; margin-bottom:20px;">
                <i class="fa fa-clipboard-list"></i> My Applications
            </h2>

            <div class="table-container">
                <h3 class="section-title">Trade License History</h3>
                <?php if (empty($tradeLicenses)): ?>
                    <p style="color:#777; padding: 10px;">No trade license applications found.</p>
                <?php else: ?>
                    <table class="app-table">
                        <thead>
                            <tr>
                                <th>Business Name</th>
                                <th>Type</th>
                                <th>Applied Date</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tradeLicenses as $license): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($license['business_name']); ?></strong>
                                    </td>
                                    <td><?php echo htmlspecialchars($license['business_type']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($license['applied_at'])); ?></td>
                                    <td>
                                        <?php if($license['payment_status'] == 'Paid'): ?>
                                            <span class="pay-success">Paid</span>
                                            <span class="trx-info">Trx: <?php echo $license['trx_id']; ?></span>
                                        <?php else: ?>
                                            <span class="pay-pending">Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($license['status']); ?>">
                                            <?php echo ucfirst($license['status']); ?>
                                        </span>

                                        <?php if (strtolower($license['status']) === 'approved'): ?>
                                            <br>
                                            <a href="download_license.php?id=<?php echo $license['id']; ?>" class="btn-download" target="_blank">
                                                <i class="fa fa-download"></i> Certificate
                                            </a>
                                        <?php endif; ?>

                                        <?php if (strtolower($license['status']) === 'rejected'): ?>
                                            <br><small style="color:#e74c3c;">Contact Office</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="table-container">
                <h3 class="section-title">NID Correction History</h3>
                <?php if (empty($nidApplications)): ?>
                    <p style="color:#777; padding: 10px;">No NID correction applications found.</p>
                <?php else: ?>
                    <table class="app-table">
                        <thead>
                            <tr>
                                <th>Correction Type</th>
                                <th>Details</th>
                                <th>Applied Date</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($nidApplications as $nidApp): ?>
                                <tr>
                                    <td>
                                        <i class="fa fa-id-card" style="color:#3498db; margin-right:5px;"></i>
                                        <?php echo htmlspecialchars($nidApp['correction_type']); ?>
                                    </td>
                                    <td style="max-width: 250px; font-size: 13px; color:#555;">
                                        <?php echo htmlspecialchars(substr($nidApp['details'], 0, 50)) . '...'; ?>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($nidApp['applied_at'])); ?></td>
                                    <td>
                                        <?php if($nidApp['payment_status'] == 'Paid'): ?>
                                            <span class="pay-success">Paid</span>
                                            <span class="trx-info">Trx: <?php echo $nidApp['trx_id']; ?></span>
                                        <?php else: ?>
                                            <span class="pay-pending">Unpaid</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($nidApp['status']); ?>">
                                            <?php echo ucfirst($nidApp['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        </main>
    </div>
</body>
</html>