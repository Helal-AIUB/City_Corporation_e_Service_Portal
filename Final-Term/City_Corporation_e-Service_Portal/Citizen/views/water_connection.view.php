<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Water Connection | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        .form-section { background: white; padding: 30px; border-radius: 12px; max-width: 800px; margin: 20px auto; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; }
        .btn-submit { background: #3498db; color: white; width: 100%; padding: 15px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .btn-submit:hover { background: #2980b9; }
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
                <li><a href="billing.php"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="form-section">
                <h2 style="color:#3498db; border-bottom:1px solid #eee; padding-bottom:15px; margin-bottom:25px;">
                    <i class="fa fa-tint"></i> New Water Connection
                </h2>

                <form action="" method="POST">
                    
                    <div class="form-group">
                        <label>Connection Type</label>
                        <select name="connection_type" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="Residential">Residential (Home) - 2000 BDT</option>
                            <option value="Commercial">Commercial (Business) - 5000 BDT</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Holding Number</label>
                        <input type="text" name="holding_no" placeholder="e.g. H-124/A" required>
                    </div>

                    <div class="form-group">
                        <label>Zone</label>
                        <select name="zone" required>
                            <option value="Zone 1">Zone 1 (North)</option>
                            <option value="Zone 2">Zone 2 (South)</option>
                            <option value="Zone 3">Zone 3 (East)</option>
                            <option value="Zone 4">Zone 4 (West)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pipe Size</label>
                        <select name="pipe_size" required>
                            <option value="0.5 inch">0.5 inch (Standard)</option>
                            <option value="1.0 inch">1.0 inch (High Flow)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Installation Address</label>
                        <textarea name="address" rows="3" placeholder="Exact location for connection..." required></textarea>
                    </div>

                    <button type="submit" name="submit_water" class="btn-submit">Submit Request</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>