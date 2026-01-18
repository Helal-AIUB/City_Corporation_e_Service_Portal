<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Official Dashboard | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        /* 1. Reset & Layout */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        
        /* FIX: Removed 'display: flex' so the body takes full width */
        body { background-color: #f4f7f6; min-height: 100vh; }

        /* Wrapper controls the layout */
        .dashboard-wrapper { width: 100%; min-height: 100vh; }

        /* 2. Sidebar (Fixed to Left) */
        .sidebar { 
            width: 260px; 
            background: #2c3e50; 
            color: white; 
            display: flex; 
            flex-direction: column; 
            position: fixed; /* Keeps it stuck to the left */
            height: 100vh; 
            top: 0; 
            left: 0; 
            z-index: 1000;
        }
        
        .sidebar .brand { padding: 25px; font-size: 22px; font-weight: bold; border-bottom: 1px solid #34495e; color: #1abc9c; display: flex; align-items: center; gap: 10px; }
        .sidebar .user-profile-preview { padding: 20px; background: #34495e; margin: 15px; border-radius: 8px; }
        .sidebar .user-profile-preview h4 { font-size: 16px; margin-bottom: 5px; }
        .sidebar .user-profile-preview small { color: #bdc3c7; font-size: 12px; }
        .sidebar .menu { list-style: none; padding: 0; margin-top: 10px; }
        .sidebar .menu li a { display: flex; align-items: center; padding: 15px 25px; color: #bdc3c7; text-decoration: none; transition: 0.3s; font-size: 15px; }
        .sidebar .menu li a i { margin-right: 15px; width: 20px; text-align: center; }
        .sidebar .menu li a:hover, .sidebar .menu li.active a { background: #1abc9c; color: white; }
        .sidebar .logout { margin-top: auto; border-top: 1px solid #34495e; }
        .sidebar .logout a { color: #e74c3c; }
        .sidebar .logout a:hover { background: #c0392b; color: white; }

        /* 3. Main Content (Fills the rest of the screen) */
        .main-content { 
            margin-left: 260px; /* Moves content right to not hide behind sidebar */
            padding: 40px; 
            width: calc(100% - 260px); /* Forces full width calculation */
        }
        
        .page-title { margin-bottom: 30px; color: #2c3e50; font-size: 28px; font-weight: 600; }

        /* 4. Stats Cards (Grid Layout) */
        /* '1fr' ensures cards stretch to fill space */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 40px; }
        
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-left: 5px solid #3498db; }
        .stat-card h3 { font-size: 14px; color: #7f8c8d; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card .number { font-size: 32px; font-weight: bold; color: #2c3e50; }
        .stat-card.orange { border-left-color: #f39c12; }
        .stat-card.green { border-left-color: #2ecc71; }

        /* 5. Tables (Full Width) */
        .table-section { 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            margin-bottom: 40px; 
            width: 100%; /* Ensures white box fills width */
        }
        .table-section h3 { margin-bottom: 25px; color: #2c3e50; font-size: 20px; border-bottom: 2px solid #f1f2f6; padding-bottom: 15px; }

        table { 
            width: 100%; /* Forces table to fill the white box */
            border-collapse: collapse; 
        }
        
        th { background: #f8f9fa; color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; color: #2c3e50; vertical-align: middle; }
        tr:hover { background-color: #fcfcfc; }

        /* 6. Badges & Status */
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-block; }
        .badge.success { background: #e8f8f5; color: #27ae60; border: 1px solid #27ae60; }
        .badge.danger { background: #fdedec; color: #e74c3c; border: 1px solid #e74c3c; }
        .badge.warning { background: #fef9e7; color: #f39c12; border: 1px solid #f39c12; }

        .status-approved { color: #27ae60; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; }
        .status-rejected { color: #e74c3c; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; }
        .status-pending { color: #f39c12; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; }

        /* 7. Action Buttons */
        .btn-action { border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; color: white; transition: 0.2s; margin-right: 5px; }
        .btn-approve { background: #2ecc71; box-shadow: 0 2px 5px rgba(46, 204, 113, 0.3); }
        .btn-approve:hover { background: #27ae60; transform: scale(1.1); }
        .btn-reject { background: #e74c3c; box-shadow: 0 2px 5px rgba(231, 76, 60, 0.3); }
        .btn-reject:hover { background: #c0392b; transform: scale(1.1); }
        .btn-disabled { background: #dfe6e9; color: #b2bec3; cursor: not-allowed; box-shadow: none; }

        .text-muted { color: #95a5a6; font-size: 12px; margin-top: 4px; display: block; }
        .trx-id { font-family: monospace; background: #f1f2f6; padding: 2px 6px; border-radius: 4px; font-size: 11px; color: #555; }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        <nav class="sidebar">
            <div class="brand">
                <i class="fa fa-building"></i> City Admin
            </div>
            <div class="user-profile-preview">
                <h4><?php echo $_SESSION['user_name'] ?? 'Official'; ?></h4>
                <small>Official Authority</small>
            </div>
            <ul class="menu">
                <li class="active"><a href="#"><i class="fa fa-th-large"></i> Overview</a></li>
                <li><a href="#"><i class="fa fa-users"></i> Citizens</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <h2 class="page-title">Official Dashboard</h2>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Applications</h3>
                    <div class="number"><?php echo $stats['total_applications']; ?></div>
                </div>
                <div class="stat-card orange">
                    <h3>Pending Requests</h3>
                    <div class="number"><?php echo $stats['pending_requests']; ?></div>
                </div>
                <div class="stat-card green">
                    <h3>Approved Licenses</h3>
                    <div class="number"><?php echo $stats['approved_licenses']; ?></div>
                </div>
            </div>

            <div class="table-section">
                <h3>Manage Trade Licenses</h3>
                <table>
                    <thead>
                        <tr>
                            <th width="25%">Applicant</th>
                            <th width="30%">Business Details</th>
                            <th width="15%">Payment</th>
                            <th width="15%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($applications)): ?>
                            <tr><td colspan="5" style="text-align:center; padding: 30px;">No trade license applications found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($applications as $app): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($app['applicant_name']); ?></strong>
                                    <span class="text-muted">NID: <?php echo htmlspecialchars($app['applicant_nid']); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($app['business_name']); ?></strong>
                                    <span class="text-muted"><?php echo htmlspecialchars($app['business_type']); ?></span>
                                </td>
                                <td>
                                    <?php if($app['payment_status'] == 'Paid'): ?>
                                        <span class="badge success">Paid</span><br>
                                        <span class="trx-id"><?php echo $app['trx_id']; ?></span>
                                    <?php else: ?>
                                        <span class="badge danger">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-<?php echo strtolower($app['status']); ?>">
                                        <?php if($app['status'] == 'approved') echo '<i class="fa fa-check-circle"></i>'; ?>
                                        <?php if($app['status'] == 'pending') echo '<i class="fa fa-clock"></i>'; ?>
                                        <?php if($app['status'] == 'rejected') echo '<i class="fa fa-times-circle"></i>'; ?>
                                        <?php echo ucfirst($app['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($app['status'] == 'pending'): ?>
                                        <form action="index.php" method="POST">
                                            <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                            <?php if($app['payment_status'] == 'Paid'): ?>
                                                <button type="submit" name="update_status" value="approved" class="btn-action btn-approve" title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn-action btn-disabled" title="Cannot Approve Unpaid" disabled>
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="submit" name="update_status" value="rejected" class="btn-action btn-reject" title="Reject">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color:#bdc3c7;">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table-section">
                <h3>Manage NID Corrections</h3>
                <table>
                    <thead>
                        <tr>
                            <th width="25%">Applicant</th>
                            <th width="30%">Correction Details</th>
                            <th width="15%">Payment</th>
                            <th width="15%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($nidApplications)): ?>
                            <tr><td colspan="5" style="text-align:center; padding: 30px;">No NID correction applications found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($nidApplications as $nidApp): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($nidApp['applicant_name']); ?></strong>
                                    <span class="text-muted">Current NID: <?php echo htmlspecialchars($nidApp['current_nid']); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($nidApp['correction_type']); ?></strong>
                                    <span class="text-muted"><?php echo substr(htmlspecialchars($nidApp['details']), 0, 50); ?>...</span>
                                </td>
                                <td>
                                    <?php if($nidApp['payment_status'] == 'Paid'): ?>
                                        <span class="badge success">Paid</span><br>
                                        <span class="trx-id"><?php echo $nidApp['trx_id']; ?></span>
                                    <?php else: ?>
                                        <span class="badge danger">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-<?php echo strtolower($nidApp['status']); ?>">
                                        <?php if($nidApp['status'] == 'approved') echo '<i class="fa fa-check-circle"></i>'; ?>
                                        <?php if($nidApp['status'] == 'pending') echo '<i class="fa fa-clock"></i>'; ?>
                                        <?php if($nidApp['status'] == 'rejected') echo '<i class="fa fa-times-circle"></i>'; ?>
                                        <?php echo ucfirst($nidApp['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($nidApp['status'] == 'pending'): ?>
                                        <form action="index.php" method="POST">
                                            <input type="hidden" name="nid_id" value="<?php echo $nidApp['id']; ?>">
                                            <?php if($nidApp['payment_status'] == 'Paid'): ?>
                                                <button type="submit" name="update_nid_status" value="approved" class="btn-action btn-approve" title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn-action btn-disabled" title="Cannot Approve Unpaid" disabled>
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button type="submit" name="update_nid_status" value="rejected" class="btn-action btn-reject" title="Reject">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color:#bdc3c7;">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        
            <div class="table-section">
                <h3>Manage Water Connections</h3>
                <table>
                    <thead>
                        <tr>
                            <th width="20%">Applicant</th>
                            <th width="25%">Location & Zone</th>
                            <th width="20%">Connection Details</th>
                            <th width="15%">Payment</th>
                            <th width="10%">Status</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($waterApplications)): ?>
                            <tr><td colspan="6" style="text-align:center; padding: 30px;">No water connection requests found.</td></tr>
                        <?php else: ?>
                            <?php foreach ($waterApplications as $water): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($water['applicant_name']); ?></strong>
                                    <span class="text-muted">NID: <?php echo htmlspecialchars($water['applicant_nid']); ?></span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($water['holding_no']); ?></strong>
                                    <span class="text-muted"><?php echo htmlspecialchars($water['zone']); ?></span>
                                    <span class="text-muted" style="font-size:11px;"><?php echo substr(htmlspecialchars($water['address']), 0, 30); ?>...</span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($water['connection_type']); ?></strong>
                                    <span class="text-muted">Pipe: <?php echo htmlspecialchars($water['pipe_size']); ?></span>
                                </td>
                                <td>
                                    <?php if($water['payment_status'] == 'Paid'): ?>
                                        <span class="badge success">Paid</span><br>
                                        <span class="trx-id"><?php echo $water['trx_id']; ?></span>
                                    <?php else: ?>
                                        <span class="badge danger">Unpaid</span>
                                        <br><small><?php echo $water['fee_amount']; ?> BDT</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-<?php echo strtolower($water['status']); ?>">
                                        <?php if($water['status'] == 'approved') echo '<i class="fa fa-check-circle"></i>'; ?>
                                        <?php if($water['status'] == 'pending') echo '<i class="fa fa-clock"></i>'; ?>
                                        <?php if($water['status'] == 'rejected') echo '<i class="fa fa-times-circle"></i>'; ?>
                                        <?php echo ucfirst($water['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($water['status'] == 'pending'): ?>
                                        <form action="index.php" method="POST">
                                            <input type="hidden" name="water_id" value="<?php echo $water['id']; ?>">
                                            
                                            <?php if($water['payment_status'] == 'Paid'): ?>
                                                <button type="submit" name="update_water_status" value="approved" class="btn-action btn-approve" title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn-action btn-disabled" title="Cannot Approve Unpaid" disabled>
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                            <?php endif; ?>

                                            <button type="submit" name="update_water_status" value="rejected" class="btn-action btn-reject" title="Reject">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color:#bdc3c7;">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</body>
</html>