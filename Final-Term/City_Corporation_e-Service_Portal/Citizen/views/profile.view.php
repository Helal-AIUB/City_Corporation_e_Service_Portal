<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        /* Extra styling just for the profile form */
        .form-section { background: white; padding: 30px; border-radius: 12px; max-width: 800px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none; }
        .form-group input:focus { border-color: #2da0a8; }
        .current-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #2da0a8; margin-bottom: 10px; }
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
                <li class="active"><a href="profile.php"><i class="fa fa-user-cog"></i> My Profile</a></li>
                <li><a href="applications.php"><i class="fa fa-file-alt"></i> My Applications</a></li>
                <li><a href="#"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>Profile Settings</h1>
                    <p>Manage your personal information</p>
                </div>
            </header>

            <div class="form-section">
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    
                    <div style="text-align:center; margin-bottom:30px;">
                        <img src="uploads/<?php echo $user['profile_pic'] ?? 'default.png'; ?>" class="current-img">
                        <br>
                        <input type="file" name="profile_pic">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" value="<?php echo $user['name']; ?>" readonly style="background:#f9f9f9; cursor:not-allowed;">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" value="<?php echo $user['email']; ?>" readonly style="background:#f9f9f9; cursor:not-allowed;">
                        </div>
                        <div class="form-group">
                            <label>NID Number</label>
                            <input type="text" name="nid" value="<?php echo $user['nid']; ?>" placeholder="Enter 10 or 17 digit NID">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" placeholder="017XXXXXXXX">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label>Home Address</label>
                        <textarea name="address" rows="3" placeholder="Enter your full address"><?php echo $user['address']; ?></textarea>
                    </div>

                    <button type="submit" name="update_profile" class="btn-apply" style="background:#2da0a8; color:white;">Save Changes</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>