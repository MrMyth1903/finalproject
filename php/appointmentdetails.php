<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Vehicle Servicing System</title>
    <link rel="icon" href="photo/Untitled-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            position: relative;
            min-height: 100vh;
            padding-bottom: 60px;
        }
        /* Header Styles */
        header {
            background: linear-gradient(135deg, rgba(24, 24, 27, 0.9), rgba(39, 39, 42, 0.8));
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            width: 70px;
            height: 70px;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }
        
        .logo img:hover {
            transform: scale(1.05);
        }
        
        .right-header {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .right-header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .right-header a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .right-header a:hover::before {
            left: 0;
        }
        
        .nav-link {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .accent-link {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }
        
        .accent-link:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }
        
        /* User Menu Styles */
        .user-menu {
            position: relative;
            display: inline-block;
        }
        
        .user-email {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 6px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }
        
        .user-email:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }
        
        .user-icon {
            font-size: 16px;
        }
        
        .logout-menu {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            background: white;
            border-radius: 8px;
            width: 180px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            overflow: hidden;
            animation: slideDown 0.3s ease forwards;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logout-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: var(--dark);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border);
        }
        
        .logout-menu-item:last-child {
            border-bottom: none;
            color:#18181b;
        }
        
        .logout-menu-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color:#18181b;
        }
        
        .logout-menu-item:hover {
            background-color:rgb(245, 245, 245);
            padding-left: 20px;
        }
        
        .logout-menu-item.danger {
            color: var(--danger);
        }
        
        .logout-menu-item.danger:hover {
            background-color: rgba(247, 37, 133, 0.05);
        }
        
        /* Show logout when hovering over email */
        .user-menu:hover .logout-menu {
            display: block;
        }
        
        /* Page Title Styles */
        .page-header {
            text-align: center;
            margin: 40px 0 30px;
            position: relative;
        }
        
        .page-title {
            font-size: 32px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .subtitle {
            color: #6c757d;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .background-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1000;
            opacity: 0.15;
            object-fit: cover;
        }
        
        header {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo img {
            height: 50px;
        }
        
        .right-header {
            display: flex;
            align-items: center;
            gap: 25px;
        }
        
        .nav-link, .accent-link {
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .nav-link {
            color: #444;
        }
        
        .nav-link:hover {
            color: #0056b3;
        }
        
        .accent-link {
            background-color: #0d6efd;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
        }
        
        .accent-link:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        
        .user-menu {
            position: relative;
        }
        
        .user-email {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            background-color:rgb(3, 99, 196);
            transition: all 0.3s ease;
        }
        
        .user-email:hover {
            background-color:rgb(29, 138, 248);
        }
        
        .user-icon {
            font-size: 18px;
            color: #0d6efd;
        }
        
        .logout-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: red;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            padding: 8px 0;
            margin-top: 8px;
            display: none;
            z-index: 10;
        }
        
        .user-menu:hover .logout-menu {
            display: block;
        }
        
        .logout-menu-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            gap: 10px;
            transition: all 0.2s ease;
        }
        
        .logout-menu-item:hover {
            background-color: #f1f3f5;
        }
        
        .logout-menu-item.danger {
            color: #dc3545;
        }
        
        .logout-menu-item.danger:hover {
            background-color: #feeaec;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .page-header {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 16px;
            color: #6c757d;
        }
        
        .stats-overview {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 25px;
            min-width: 180px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            height: 50px;
            width: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .icon-blue {
            background-color: #4dabf7;
        }
        
        .icon-purple {
            background-color: #9775fa;
        }
        
        .icon-teal {
            background-color: #20c997;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #212529;
            line-height: 1.2;
        }
        
        .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
        
        .data-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        #data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        #data-table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }
        
        #data-table th i {
            margin-right: 5px;
            color: #6c757d;
        }
        
        #data-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }
        
        #data-table tr:last-child td {
            border-bottom: none;
        }
        
        #data-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .vehicle-type {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .vehicle-number {
            font-size: 14px;
            color: #6c757d;
        }
        
        .contact-info div {
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .contact-info i {
            width: 16px;
            color: #6c757d;
        }
        
        .service-badge {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .quantity-badge {
            font-size: 14px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .date-display, .location-display {
            font-size: 14px;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 5px;
        }
        
        .price-display {
            font-weight: 600;
            color: #198754;
            font-size: 16px;
            margin: 8px 0;
        }
        
        .price-value {
            font-weight: 700;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-icon {
            font-size: 60px;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .empty-title {
            font-size: 24px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }
        
        .empty-text {
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        .empty-button {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .empty-button:hover {
            background-color: #0056b3;
        }
        
        .responsive-table {
            overflow-x: auto;
        }
        
        /* Compact view for mobile */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .right-header {
                width: 100%;
                justify-content: space-around;
                flex-wrap: wrap;
            }
            
            .stats-overview {
                flex-direction: column;
                align-items: center;
            }
            
            .stat-card {
                width: 100%;
                max-width: 300px;
            }
            
            #data-table td {
                padding: 10px;
            }
            
            .page-title {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <video class="background-video" id="bgVideo" autoplay muted loop>
        <source src="video/istockphoto-1680698591-640_adpp_is.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="photo/Blue_Gold_Minimalist_Car_Showroom_Logo-removebg-preview.png" alt="Vehicle Logo">
            </div>
            <div class="right-header">
                <a href="../home.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="blog.php" class="nav-link"><i class="fas fa-blog"></i> Blog</a>
                <a href="../appointment.php" class="accent-link"><i class="fas fa-calendar-check"></i> Book Appointment</a>
                <div class="user-menu">
                    <div class="user-email">
                        <i class="fas fa-user-circle user-icon"></i>
                        <?php echo htmlspecialchars($_SESSION['email']); ?>
                        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </div>
                    <div class="logout-menu">
                        <a href="orderdetails.php" class="logout-menu-item">
                            <i class="fas fa-clipboard-list"></i> My Orders
                        </a>
                        <a href="appointmentdetails.php" class="logout-menu-item">
                            <i class="fas fa-clipboard-check"></i> Appointment Details
                        </a>
                        <a href="../logout.php" class="logout-menu-item danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">My Appointment History</h1>
            <p class="subtitle">Track and manage all your vehicle service appointments</p>
        </div>
        
        <?php
        include 'signup.php'; // Changed from signup.php to config.php which should contain database connection
        error_reporting(E_ALL);

        // Fetch records from the database
        $query = "SELECT * FROM appointment WHERE EMAIL='" . mysqli_real_escape_string($con, $_SESSION['email']) . "'";
        $run = mysqli_query($con, $query);
        
        if (!$run) {
            echo "<div class='error-message'>Error: " . mysqli_error($con) . "</div>";
        } else {
            $count = mysqli_num_rows($run);
            
            // Count different service types
            $total_orders = $count;
            $total_vehicles = 0;
            $vehicle_types = [];
            
            // if ($count > 0) {
            //     while ($data = mysqli_fetch_assoc($run)) {
            //         if (!in_array($data['V_NUMBER'], $vehicle_types)) {
            //             $vehicle_types[] = $data['V_NUMBER'];
            //             $total_vehicles++;
            //         }
            //     }
                
            //     // Reset the result pointer
            //     mysqli_data_seek($run, 0);
            // }
        ?>
        
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $total_orders; ?></div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <i class="fas fa-car"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo $total_vehicles; ?></div>
                    <div class="stat-label">Vehicles</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-teal">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value"><?php echo date('M Y'); ?></div>
                    <div class="stat-label">Current Period</div>
                </div>
            </div>
        </div>

        <?php if ($count > 0) { ?>
        <div class="data-container">
            <div class="responsive-table">
                <table id="data-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> Order ID</th>
                            <th><i class="fas fa-car"></i> Service Details</th>
                            <th><i class="fas fa-calendar-alt"></i> Schedule</th>
                            <th><i class="fas fa-user"></i> Customer Info</th>
                            <th><i class="fas fa-car-alt"></i> Vehicle Details</th>
                            <th><i class="fas fa-info-circle"></i> Additional Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($run)) { ?>
                            <tr id="row-<?php echo $order['ID']; ?>">
                                <td>#<?php echo htmlspecialchars($order['ID']); ?></td>
                                <td>
                                    <div class="vehicle-type"><?php echo htmlspecialchars($order['LEVEL']); ?></div>
                                    <div class="vehicle-number"><?php echo htmlspecialchars($order['SERVICE']); ?></div>
                                    <div class="price-display">₹<?php echo htmlspecialchars($order['PRICE']); ?></div>
                                </td>
                                <td>
                                    <div class="date-display">
                                        <i class="far fa-calendar-alt"></i>
                                        <span class="date-value"><?php echo htmlspecialchars($order['DATE']); ?></span>
                                    </div>
                                    <div class="date-display">
                                        <i class="far fa-clock"></i>
                                        <span class="date-value"><?php echo htmlspecialchars($order['TIME']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="service-badge"><?php echo htmlspecialchars($order['NAME']); ?></div>
                                    <div class="contact-info">
                                        <div>
                                            <i class="fas fa-envelope"></i>
                                            <?php echo htmlspecialchars($order['EMAIL']); ?>
                                        </div>
                                        <div>
                                            <i class="fas fa-phone"></i>
                                            <?php echo htmlspecialchars($order['PHONE_NUMBER']); ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-display">
                                        <i class="fas fa-car"></i>
                                        <span class="date-value"><?php echo htmlspecialchars($order['VEHICLE_NO']); ?></span>
                                    </div>
                                    <div class="date-display">
                                        <i class="fas fa-cogs"></i>
                                        <span class="date-value"><?php echo htmlspecialchars($order['ENGINEE']); ?></span>
                                    </div>
                                    <div class="date-display">
                                        <i class="fas fa-fingerprint"></i>
                                        <span class="date-value"><?php echo htmlspecialchars($order['CHASIS']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-display">
                                        <i class="fas fa-tools"></i>
                                        <span class="date-value"><?php echo htmlspecialchars($order['SPHERE_PART']); ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } else { ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3 class="empty-title">No service orders found</h3>
                <p class="empty-text">You haven't booked any service appointments yet.</p>
                <a href="../appointment.php" class="empty-button">
                    <i class="fas fa-calendar-plus"></i> Book Your First Service
                </a>
            </div>
        <?php } ?>
        <?php } ?>
    </div>

    <script>
        // Enable dropdown functionality 
        document.addEventListener('DOMContentLoaded', function() {
            const userMenu = document.querySelector('.user-menu');
            const logoutMenu = document.querySelector('.logout-menu');
            
            userMenu.addEventListener('click', function(e) {
                logoutMenu.style.display = logoutMenu.style.display === 'block' ? 'none' : 'block';
                e.stopPropagation();
            });
            
            document.addEventListener('click', function() {
                logoutMenu.style.display = 'none';
            });
            
            logoutMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>