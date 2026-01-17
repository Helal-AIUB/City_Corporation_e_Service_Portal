<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Citizen Dashboard | City Corp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

    <div class="dashboard-wrapper">
        <nav class="sidebar">
            <div class="brand">
                <h2><i class="fa fa-building"></i> CityCorp</h2>
            </div>
            <div class="user-profile-preview">
                <img src="uploads/<?php echo $user['profile_pic'] ?? 'default.png'; ?>" alt="Profile">
                <div>
                    <h4><?php echo $_SESSION['user_name']; ?></h4>
                    <small>Citizen</small>
                </div>
            </div>
            <ul class="menu">
                <li class="active"><a href="index.php"><i class="fa fa-th-large"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="fa fa-user-cog"></i> My Profile</a></li>
                <li><a href="applications.php"><i class="fa fa-file-alt"></i> My Applications</a></li>
                <li><a href="billing.php"><i class="fa fa-credit-card"></i> Pay Bills</a></li>
                <li class="logout"><a href="../../Home/public/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>Welcome back, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>! 👋</h1>
                    <p>What service do you need today?</p>
                </div>
                <div class="notification-bell">
                    <i class="fa fa-bell"></i>
                    <span class="badge">2</span>
                </div>
            </header>

            <section class="services-section">
                <h3 class="section-title">Available e-Services</h3>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="icon-box blue"><i class="fa fa-id-card"></i></div>
                        <h3>NID Correction</h3>
                        <p>Apply for NID updates or corrections.</p>

                        <a href="nid_correction.php" class="btn-apply" style="text-decoration: none; display: block; text-align: center;">Apply Now</a>
                    </div>
                    <div class="service-card">
                        <div class="icon-box green"><i class="fa fa-tint"></i></div>
                        <h3>New Water Connection</h3>
                        <p>Request a new water line for your home.</p>
                        <button class="btn-apply">Apply Now</button>
                    </div>
                    <div class="service-card">
                        <div class="icon-box orange"><i class="fa fa-file-contract"></i></div>
                        <h3>Trade License</h3>
                        <p>Renew or apply for a business trade license.</p>
                        <a href="apply_trade.php" style="text-decoration: none;">
                            <button class="btn-apply">Apply Now</button>
                        </a>
                    </div>
                    <div class="service-card">
                        <div class="icon-box purple"><i class="fa fa-trash-alt"></i></div>
                        <h3>Waste Management</h3>
                        <p>Schedule special waste pickup services.</p>
                        <button class="btn-apply">Apply Now</button>
                    </div>
                </div>
            </section>

            <section class="activity-section">
                <h3 class="section-title">Recent Activity</h3>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="status pending">Pending</div>
                        <div class="details">
                            <h4>Trade License Renewal</h4>
                            <small>Applied on Oct 24, 2025</small>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>