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
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --success-dark: #4361ee;
            --danger: #f72585;
            --dark: #212529;
            --light: #f8f9fa;
            --border: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
            overflow-x: hidden;
        }
        
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.5;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
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
            display: none; /* Hide by default */
            position: absolute;
            top: 120%;
            right: 0;
            background: red;
            border-radius: 8px;
            width: 180px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            overflow: hidden;
            animation: slideDown 0.3s ease forwards;
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
            color: black;
        }
        
        .logout-menu-item.danger:hover {
            background-color: rgba(247, 37, 133, 0.05);
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
        
        /* Orders Table Styles */
        .data-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 40px;
            overflow: hidden;
            position: relative;
        }
        
        .data-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
        }
        
        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        
        th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .service-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        
        .vehicle-type {
            font-weight: 600;
            font-size: 16px;
            color: var(--dark);
        }
        
        .vehicle-number {
            color: var(--primary);
            font-family: monospace;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            background: rgba(67, 97, 238, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .date-display {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .date-display i {
            color: var(--primary);
        }
        
        .location-display {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 14px;
        }
        
        .location-display i {
            color: var(--success);
        }
        
        .price-display {
            margin-top: 8px;
            font-weight: bold;
            color: var(--dark);
            font-size: 16px;
        }
        
        .price-value {
            color: var(--secondary);
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .contact-email, .contact-phone {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .contact-email i, .contact-phone i {
            color: var(--primary);
            width: 16px;
        }
        
        .service-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-dark);
            margin-bottom: 5px;
        }
        
        .quantity-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background-color: rgba(241, 250, 238, 0.8);
            color: #2a9d8f;
        }
        
        /* Empty State Styles */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
            text-align: center;
        }
        
        .empty-state i {
            font-size: 60px;
            color: #e9ecef;
            margin-bottom: 20px;
        }
        
        .empty-state p {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 20px;
        }
        
        .empty-state .btn {
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .empty-state .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.3);
        }
        
        /* Responsive Order Card Layout for Mobile */
        .order-cards-container {
            display: none;
        }
        
        /* Stats Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
        
        .icon-blue {
            background: linear-gradient(135deg, #4361ee, #4895ef);
        }
        
        .icon-purple {
            background: linear-gradient(135deg, #7209b7, #3f37c9);
        }
        
        .icon-teal {
            background: linear-gradient(135deg, #0096c7, #0077b6);
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
        
        /* Footer Styles */
        footer {
            background-color: #18181b;
            color: #f8f9fa;
            padding: 50px 0 20px;
            position: relative;
            margin-top: 100px;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
        }
        
        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .footer-section {
            flex: 1 1 200px;
            margin: 0 20px 30px;
        }
        
        .footer-section h3 {
            font-size: 18px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            position: relative;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-section ul li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .footer-section ul li:before {
            content: '→';
            margin-right: 10px;
            color: var(--primary);
        }
        
        .footer-section ul li a {
            color: #e9ecef;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .footer-section ul li a:hover {
            color: var(--primary-light);
            padding-left: 5px;
        }
        
        .footer-section p {
            line-height: 1.6;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-section p i {
            color: var(--primary);
            width: 16px;
        }
        
        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }
        
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            transform: translateY(-3px);
        }
        
        .social-icons img {
            width: 18px;
            height: 18px;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 14px;
            color: #adb5bd;
        }
        
        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }
        
        /* Badge Animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(67, 97, 238, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(67, 97, 238, 0);
            }
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .container {
                padding: 0 15px;
            }
            
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .right-header {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .stats-overview {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            /* Hide table on mobile */
            table {
                display: none;
            }
            
            /* Show cards on mobile */
            .order-cards-container {
                display: block;
            }
            
            .order-card {
                background: white;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 15px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                position: relative;
                overflow: hidden;
            }
            
            .order-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                height: 5px;
                width: 100%;
                background: linear-gradient(to right, var(--primary), var(--secondary));
            }
            
            .order-card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #e9ecef;
            }
            
            .order-id {
                font-size: 16px;
                font-weight: 600;
                color: var(--dark);
            }
            
            .order-vehicle {
                margin-bottom: 15px;
            }
            
            .order-detail-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
                font-size: 14px;
            }
            
            .order-detail-label {
                font-weight: 500;
                color: #6c757d;
            }
            
            .order-detail-value {
                text-align: right;
                font-weight: 500;
            }
            
            .order-card-footer {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #e9ecef;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .footer-section {
                flex: 100%;
                margin-bottom: 30px;
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
                    <div class="user-email" id="userEmail">
                        <i class="fas fa-user-circle user-icon"></i>
                        <?php echo htmlspecialchars($_SESSION['email']); ?>
                        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </div>
                    <div class="logout-menu" id="logoutMenu">
                        <a href="orderdetails.php" class="logout-menu-item">
                            <i class="fas fa-clipboard-list"></i> My Orders
                        </a>
                        <a href="appointmentdetails.php" class="logout-menu-item">
                            <i class="fas fa-clipboard-check"></i> Appointment Details
                        </a>
                        <a href="../password.html" class="logout-menu-item">
                            <i class="fas fa-clipboard-list"></i> Change Password
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
            <h1 class="page-title">My Sphere Parts Order Details</h1>
            <p class="subtitle">Track and manage all your vehicle Order details </p>
        </div>
        
        <?php
        include 'signup.php';
        error_reporting(E_ALL);

        // Fetch records from the database
        $query = "SELECT * FROM service WHERE EMAIL='" . mysqli_real_escape_string($con, $_SESSION['email']) . "'";
        $run = mysqli_query($con, $query);
        $count = mysqli_num_rows($run);
        
        // Count different service types
        $total_orders = $count;
        $total_vehicles = 0;
        $vehicle_types = [];
        
        if ($count > 0) {
            while ($data = mysqli_fetch_assoc($run)) {
                if (!in_array($data['V_NUMBER'], $vehicle_types)) {
                    $vehicle_types[] = $data['V_NUMBER'];
                    $total_vehicles++;
                }
            }
            
            // Reset the result pointer
            mysqli_data_seek($run, 0);
        }
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
            <table id="data-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> Order ID</th>
                        <th><i class="fas fa-car"></i> Vehicle</th>
                        <th><i class="fas fa-address-card"></i> Contact Info</th>
                        <th><i class="fas fa-tools"></i> Service Details</th>
                        <th><i class="fas fa-map-marker-alt"></i> Date & Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($run)) { ?>
                        <tr id="row-<?php echo $order['ID']; ?>">
                            <td>#<?php echo htmlspecialchars($order['ID']); ?></td>
                            <td>
                                <div class="vehicle-type"><?php echo htmlspecialchars($order['V_TYPE']); ?></div>
                                <div class="vehicle-number"><?php echo htmlspecialchars($order['V_NUMBER']); ?></div>
                            </td>
                            <td class="contact-info">
                                <div class="contact-email">
                                    <i class="fas fa-envelope"></i>
                                    <?php echo htmlspecialchars($order['EMAIL']); ?>
                                </div>
                                <div class="contact-phone">
                                    <i class="fas fa-phone"></i>
                                    <?php echo htmlspecialchars($order['PHONE']); ?>
                                </div>
                            </td>
                            <td>
                                <div class="service-badge"><?php echo htmlspecialchars($order['WANT']); ?></div>
                                <div class="quantity-badge">
                                    <i class="fas fa-layer-group"></i>
                                    Quantity: <?php echo htmlspecialchars($order['QUANTITY']); ?>
                                </div>
                                <div class="price-display">₹<span class="price-value"><?php echo htmlspecialchars($order['PRICE']); ?></span></div>
                            </td>
                            <td>
                                <div class="date-display">
                                    <i class="far fa-calendar-alt"></i> 
                                    <span class="date-value"><?php echo htmlspecialchars($order['DATE']); ?></span>
                                </div>
                                <div class="location-display">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlspecialchars($order['ADDRESS']); ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
        <div class="empty-state">
            <i class="fas fa-exclamation-circle"></i>
            <p>No service orders found. Please book an appointment.</p>
            <a href="../appointment.php" class="btn">Book Appointment</a>
        </div>
        <?php } ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userEmail = document.getElementById('userEmail');
            const logoutMenu = document.getElementById('logoutMenu');

            userEmail.addEventListener('click', function() {
                // Toggle the display of the logout menu
                if (logoutMenu.style.display === 'block') {
                    logoutMenu.style.display = 'none';
                } else {
                    logoutMenu.style.display = 'block';
                }
            });

            // Optional: Close the dropdown if clicking outside of it
            window.addEventListener('click', function(event) {
                if (!userEmail.contains(event.target) && !logoutMenu.contains(event.target)) {
                    logoutMenu.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>