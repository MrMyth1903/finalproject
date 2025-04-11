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
    <title>Appointment Booking</title>
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
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--audi-dark);
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--audi-red);
            box-shadow: 0 0 0 2px rgba(226, 0, 0, 0.2);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .service-options {
            margin-top: 20px;
        }
        
        .price-display {
            background-color: var(--audi-light);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: 600;
            border-left: 4px solid var(--audi-red);
        }
        
        .price-display span {
            color: var(--audi-red);
        }
        
        .submit-button {
            text-align: center;
            margin-top: 30px;
        }
        
        button {
            background-color: var(--audi-red);
            color: white;
            border: none;
            padding: 14px 30px;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(226, 0, 0, 0.3);
        }
        
        button:hover {
            background-color: #c00000;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(226, 0, 0, 0.4);
        }
        
        .icon-input {
            position: relative;
        }
        
        .icon-input i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #777;
        }
        
        .icon-input input, .icon-input select {
            padding-left: 40px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .quantity-btn {
            background-color: #f1f1f1;
            border: none;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            color: #555;
            transition: all 0.2s ease;
        }
        
        .quantity-btn:hover {
            background-color: #e0e0e0;
        }
        
        .quantity-input {
            width: 60px;
            text-align: center;
            border: none;
            padding: 10px 0;
            font-size: 16px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-radius: 0;
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
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .video-container {
            display: none;
        }
        header {
            background-color: #0073e6;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }
        header h1 {
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            font-size: 1.1rem;
            color: #333;
            display: block;
            margin-bottom: 0.5rem;
        }
        select, input[type="text"], input[type="date"], input[type="time"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .button-container {
            text-align: center;
        }
        .submit-btn {
            background-color: #0073e6;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #005bb5;
        }
        .error {
            color: red;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        .success {
            color: green;
            font-size: 1rem;
            margin-top: 1rem;
            text-align: center;
        }
        #other-service {
            display: none;
            margin-top: 1rem;
        }
        
        /* Service Level Selection Styles */
        .service-level-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 15px;
        }
        
        .service-level-btn {
            flex: 1;
            padding: 1.2rem 1rem;
            text-align: center;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .service-level-btn i {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .service-level-btn span {
            display: block;
            font-size: 0.85rem;
            margin-top: 0.25rem;
            font-weight: normal;
            opacity: 0.8;
        }
        
        .level-1-btn {
            background: linear-gradient(135deg, #4361ee, #4895ef);
        }
        
        .level-2-btn {
            background: linear-gradient(135deg, #3a0ca3, #4361ee);
        }
        
        .level-3-btn {
            background: linear-gradient(135deg, #240046, #3a0ca3);
        }
        .level-4-btn {
            background: linear-gradient(135deg, #240046, #3a0ca3);
        }
        
        .service-level-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .service-level-btn:active {
            transform: translateY(-2px);
        }
        
        /* Forms display control */
        .service-form {
            display: none;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 0.6rem 1.2rem;
            background: none;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            color: #333;
        }
        
        .back-btn i {
            margin-right: 0.5rem;
        }
        
        .back-btn:hover {
            background-color: #f3f4f6;
            border-color: #a0a0a0;
        }
        
        /* Service level details at top of each form */
        .service-details {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 1.2rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #4361ee;
        }
        
        .service-details h3 {
            margin-top: 0;
            color: #333;
            margin-bottom: 0.8rem;
        }
        
        .service-details ul {
            margin: 0;
            padding-left: 1.2rem;
        }
        
        .service-details li {
            margin-bottom: 0.3rem;
        }
        
        /* Active service level button */
        .selection-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .selection-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        /* Add these styles to your existing CSS in the <style> tag */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 10px;
    margin-bottom: 10px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.checkbox-item:hover {
    background-color: rgba(67, 97, 238, 0.05);
}

.checkbox-item input[type="checkbox"] {
    margin-right: 10px;
    width: 18px;
    height: 18px;
    accent-color: #4361ee;
    cursor: pointer;
}

.checkbox-item label {
    margin-bottom: 0;
    cursor: pointer;
    font-size: 14px;
    font-weight: normal;
    display: inline-block;
}

/* For mobile responsiveness */
@media (max-width: 768px) {
    .checkbox-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media (max-width: 576px) {
    .checkbox-grid {
        grid-template-columns: 1fr;
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
                <a href="home.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="php/blog.php" class="nav-link"><i class="fas fa-blog"></i> Blog</a>
                <a href="appointment.html" class="accent-link"><i class="fas fa-calendar-check"></i> Book Appointment</a>
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
                        <a href="php/appointmentdetails.php" class="logout-menu-item">
                            <i class="fas fa-clipboard-list"></i> Appointment Details
                        </a>
                        <a href="logout.php" class="logout-menu-item danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="selection-container" id="service-selection">
            <h2 class="selection-title">Select Vehicle Service Level</h2>
            <div class="service-level-container">
                <button class="service-level-btn level-1-btn" id="level1Btn">
                    <i class="fas fa-check-circle"></i>
                    Level 1 Service
                    <span>Basic Maintenance<br>₹9999/-</span>

                </button>
                <button class="service-level-btn level-2-btn" id="level2Btn">
                    <i class="fas fa-tools"></i>
                    Level 2 Service
                    <span>Intermediate Service<br>₹15000/-</span>
                </button>
                <button class="service-level-btn level-3-btn" id="level3Btn">
                    <i class="fas fa-cogs"></i>
                    Level 3 Service
                    <span>Comprehensive Service<br>₹35000/-</span>
                </button>
                <button class="service-level-btn level-4-btn" id="level4Btn">
                    <i class="fas fa-cogs"></i>
                    Level 4 Service
                    <span>Customize Service<br>₹ As per service</span>
                </button>
            </div>
        </div>

        <!-- Level 1 Service Form -->
        <div class="service-form" id="level1Form">
            <button class="back-btn" id="backBtn1">
                <i class="fas fa-arrow-left"></i> Back to selection
            </button>
            <h2>Level 1 Service - Basic Maintenance</h2>
            <div class="service-details">
                <h3>Services Included:</h3>
                <ul>
                    <li>Oil & Filter Change</li>
                    <li>Tire Rotation</li>
                    <li>Fluid Level Check & Top-up</li>
                    <li>Multi-Point Inspection (Lights, Battery, Brakes)</li>
                    <li>Air Filter Check</li>
                    <li>Cabin Filter Check</li>
                </ul>
            </div>
            <form action="php/appoiintment.php" method="post" id="level1AppointmentForm">
                <input type="hidden" name="service_level" value="Level 1">
                <div class="form-group">
                    <label for="service1">Select Vehicle Type</label>
                    <select id="service1" name="service" required>
                        <option value="">--Select Vehicle Type--</option>
                        <option value="Car Maintenance">Car Maintenance</option>
                        <option value="Bike Servicing">Bike Servicing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date1">Preferred Date</label>
                    <input type="date" id="date1" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time1">Preferred Time</label>
                    <input type="time" id="time1" name="time" required>
                </div>

                <div class="form-group">
                    <label for="name1">Owner Name</label>
                    <input type="text" id="name1" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="name1">Email</label>
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" placeholder="Enter your engine number" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" placeholder="Enter your chassis number" required>
                </div>
                <input type="hidden" name="price" value="9999">
                <div class="form-group">
                    <label for="phone_number1">Phone Number</label>
                    <input type="text" id="phone_number1" name="phone_number" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="comments1">Additional Comments</label>
                    <textarea id="comments1" name="comments" rows="3" placeholder="Any specific requests or concerns?" class="form-control"></textarea>
                </div>

                <div class="button-container">
                    <button type="submit" class="submit-btn" name="submit">Schedule Level 1 Service</button>
                </div>
            </form>
        </div>

        <!-- Level 2 Service Form -->
        <div class="service-form" id="level2Form">
            <button class="back-btn" id="backBtn2">
                <i class="fas fa-arrow-left"></i> Back to selection
            </button>
            <h2>Level 2 Service - Intermediate Maintenance</h2>
            <div class="service-details">
                <h3>Services Included:</h3>
                <ul>
                    <li>All Level 1 Services</li>
                    <li>Brake Inspection & Adjustment</li>
                    <li>Engine Tune-up</li>
                    <li>Air & Cabin Filter Replacement</li>
                    <li>Battery Service & Test</li>
                    <li>Suspension Check</li>
                    <li>Cooling System Inspection</li>
                </ul>
            </div>
            <form action="php/appoiintment.php" method="post" id="level1AppointmentForm">
                <input type="hidden" name="service_level" value="Level 2">
                <div class="form-group">
                    <label for="service1">Select Vehicle Type</label>
                    <select id="service1" name="service" required>
                        <option value="">--Select Vehicle Type--</option>
                        <option value="Car Maintenance">Car Maintenance</option>
                        <option value="Bike Servicing">Bike Servicing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date1">Preferred Date</label>
                    <input type="date" id="date1" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time1">Preferred Time</label>
                    <input type="time" id="time1" name="time" required>
                </div>

                <div class="form-group">
                    <label for="name1">Owner Name</label>
                    <input type="text" id="name1" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="name1">Email</label>
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" placeholder="Enter your engine number" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" placeholder="Enter your chassis number" required>
                </div>
                <input type="hidden" name="price" value="15000">
                <div class="form-group">
                    <label for="phone_number1">Phone Number</label>
                    <input type="text" id="phone_number1" name="phone_number" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="comments1">Additional Comments</label>
                    <textarea id="comments1" name="comments" rows="3" placeholder="Any specific requests or concerns?" class="form-control"></textarea>
                </div>

                <div class="button-container">
                    <button type="submit" class="submit-btn" name="submit">Schedule Level 1 Service</button>
                </div>
            </form>
        </div>

        <!-- Level 3 Service Form -->
        <div class="service-form" id="level3Form">
            <button class="back-btn" id="backBtn3">
                <i class="fas fa-arrow-left"></i> Back to selection
            </button>
            <h2>Level 3 Service - Comprehensive Maintenance</h2>
            <div class="service-details">
                <h3>Services Included:</h3>
                <ul>
                    <li>Transmission Fluid Change</li>
                    <li>Engine Diagnostics</li>
                    <li>Fuel Injection Cleaning</li>
                    <li>Power Steering Fluid Change</li>
                    <li>Differential Fluid Change (if applicable)</li>
                    <li>Wheel Alignment Check</li>
                    <li>Spark Plug Replacement</li>
                    <li>Complete Electrical System Check</li>
                </ul>
            </div>
            <form action="php/appoiintment.php" method="post" id="level1AppointmentForm">
                <input type="hidden" name="service_level" value="Level 3">
                <div class="form-group">
                    <label for="service1">Select Vehicle Type</label>
                    <select id="service1" name="service" required>
                        <option value="">--Select Vehicle Type--</option>
                        <option value="Car Maintenance">Car Maintenance</option>
                        <option value="Bike Servicing">Bike Servicing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date1">Preferred Date</label>
                    <input type="date" id="date1" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time1">Preferred Time</label>
                    <input type="time" id="time1" name="time" required>
                </div>

                <div class="form-group">
                    <label for="name1">Owner Name</label>
                    <input type="text" id="name1" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="name1">Email</label>
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" placeholder="Enter your engine number" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" placeholder="Enter your chassis number" required>
                </div>
                <input type="hidden" name="price" value="35000">
                <div class="form-group">
                    <label for="phone_number1">Phone Number</label>
                    <input type="text" id="phone_number1" name="phone_number" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="comments1">Additional Comments</label>
                    <textarea id="comments1" name="comments" rows="3" placeholder="Any specific requests or concerns?" class="form-control"></textarea>
                </div>

                <div class="button-container">
                    <button type="submit" class="submit-btn" name="submit">Schedule Level 1 Service</button>
                </div>
            </form>
        </div>

        <!-- Level 4 Service Form -->
<d class="service-form" id="level4Form">
    <button class="back-btn" id="backBtn4">
        <i class="fas fa-arrow-left"></i> Back to selection
    </button>
    <h2>Level 4 Service - Customize service</h2>
    <br>
    <form action="php/apppoiintment.php" method="post" class="card">
    <input type="hidden" name="service_level" value="Customized Service">
                <div class="form-group">
                    <label for="service1">Select Vehicle Type</label>
                    <select id="service1" name="service" required>
                        <option value="">--Select Vehicle Type--</option>
                        <option value="Car Maintenance">Car Maintenance</option>
                        <option value="Bike Servicing">Bike Servicing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date1">Preferred Date</label>
                    <input type="date" id="date1" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time1">Preferred Time</label>
                    <input type="time" id="time1" name="time" required>
                </div>

                <div class="form-group">
                    <label for="name1">Owner Name</label>
                    <input type="text" id="name1" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="name1">Email</label>
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" required>
                </div>
                
                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" placeholder="Enter your engine number" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" placeholder="Enter your chassis number" required>
                </div>
                <div class="form-group">
                    <label for="phone_number1">Phone Number</label>
                    <input type="text" id="phone_number1" name="phone_number" placeholder="Enter your phone number" required>
                </div>
                    <div class="form-section">
                <h2>Service Requirements</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="want">Service Type / Spare Parts</label>
                        <div class="icon-input">
                            <i class="fas fa-tools"></i>
                            <select id="want" name="custom_services" required>
                                <option value="">--Select Service or Part--</option>
                                
                                <optgroup label="Service Types">
                                    <option value="Tire Change">Tire Change</option>
                                    <option value="Mobil Change">Oil Change</option>
                                    <option value="Brake Shoe Change">Brake Shoe Change</option>
                                    <option value="Coolent Change">Coolant Change</option>
                                    <option value="Brake Issue">Brake Issue</option>
                                    <option value="Diesel Tank">Diesel Tank</option>
                                    <option value="Mobile Tank">Mobile Tank</option>
                                    <option value="Head Light">Head Light</option>
                                    <option value="Deeper">Deeper</option>
                                </optgroup>
                                
                                <optgroup label="Engine Parts">
                                    <option value="Engine Control Module">Engine Control Module (ECM)</option>
                                    <option value="Timing Belt Kit">Timing Belt Kit</option>
                                    <option value="Engine Mounts">Engine Mounts</option>
                                    <option value="Crankshaft Sensor">Crankshaft Position Sensor</option>
                                    <option value="Camshaft">Camshaft</option>
                                    <option value="Pistons">Pistons</option>
                                    <option value="Connecting Rods">Connecting Rods</option>
                                    <option value="Oil Pump">Oil Pump</option>
                                    <option value="Turbocharger">Turbocharger</option>
                                    <option value="Intercooler">Intercooler</option>
                                </optgroup>
                                
                                <optgroup label="Transmission">
                                    <option value="Transmission Assembly">Transmission Assembly</option>
                                    <option value="Clutch Kit">Clutch Kit</option>
                                    <option value="Flywheel">Flywheel</option>
                                    <option value="Transmission Fluid">Transmission Fluid</option>
                                    <option value="Gear Selector">Gear Selector</option>
                                    <option value="DSG Mechatronic Unit">DSG Mechatronic Unit</option>
                                </optgroup>
                                
                                <optgroup label="Brake System">
                                    <option value="Brake Pads">Brake Pads</option>
                                    <option value="Brake Rotors">Brake Rotors</option>
                                    <option value="Brake Calipers">Brake Calipers</option>
                                    <option value="ABS Control Module">ABS Control Module</option>
                                    <option value="Brake Lines">Brake Lines</option>
                                    <option value="Brake Master Cylinder">Brake Master Cylinder</option>
                                </optgroup>
                                
                                <optgroup label="Suspension & Steering">
                                    <option value="Shock Absorbers">Shock Absorbers</option>
                                    <option value="Struts">Struts</option>
                                    <option value="Control Arms">Control Arms</option>
                                    <option value="Tie Rods">Tie Rods</option>
                                    <option value="Sway Bar Links">Sway Bar Links</option>
                                    <option value="Ball Joints">Ball Joints</option>
                                    <option value="Steering Rack">Steering Rack</option>
                                    <option value="Power Steering Pump">Power Steering Pump</option>
                                    <option value="Wheel Bearings">Wheel Bearings</option>
                                </optgroup>
                                
                                <optgroup label="Electrical System">
                                    <option value="Battery">Battery</option>
                                    <option value="Alternator">Alternator</option>
                                    <option value="Starter Motor">Starter Motor</option>
                                    <option value="Ignition Coils">Ignition Coils</option>
                                    <option value="Spark Plugs">Spark Plugs</option>
                                    <option value="Fuse Box">Fuse Box</option>
                                    <option value="Headlight Assembly">Headlight Assembly</option>
                                    <option value="Tail Light Assembly">Tail Light Assembly</option>
                                    <option value="Turn Signal Switch">Turn Signal Switch</option>
                                    <option value="Window Regulator">Window Regulator</option>
                                    <option value="MMI Control Unit">MMI Control Unit</option>
                                </optgroup>
                                
                                <optgroup label="Cooling System">
                                    <option value="Radiator">Radiator</option>
                                    <option value="Water Pump">Water Pump</option>
                                    <option value="Thermostat">Thermostat</option>
                                    <option value="Cooling Fan">Cooling Fan</option>
                                    <option value="Coolant Reservoir">Coolant Reservoir</option>
                                    <option value="Radiator Hoses">Radiator Hoses</option>
                                </optgroup>
                                
                                <optgroup label="Fuel System">
                                    <option value="Fuel Pump">Fuel Pump</option>
                                    <option value="Fuel Injectors">Fuel Injectors</option>
                                    <option value="Fuel Filter">Fuel Filter</option>
                                    <option value="Fuel Pressure Regulator">Fuel Pressure Regulator</option>
                                    <option value="Fuel Tank">Fuel Tank</option>
                                    <option value="Fuel Lines">Fuel Lines</option>
                                </optgroup>
                                
                                <optgroup label="Exhaust System">
                                    <option value="Catalytic Converter">Catalytic Converter</option>
                                    <option value="Exhaust Manifold">Exhaust Manifold</option>
                                    <option value="Muffler">Muffler</option>
                                    <option value="Oxygen Sensor">Oxygen Sensor</option>
                                    <option value="Exhaust Pipes">Exhaust Pipes</option>
                                    <option value="DPF Filter">DPF Filter</option>
                                </optgroup>
                                
                                <optgroup label="Body Parts">
                                    <option value="Front Bumper">Front Bumper</option>
                                    <option value="Rear Bumper">Rear Bumper</option>
                                    <option value="Hood">Hood</option>
                                    <option value="Trunk Lid">Trunk Lid</option>
                                    <option value="Doors">Doors</option>
                                    <option value="Fenders">Fenders</option>
                                    <option value="Grille">Grille</option>
                                    <option value="Side Mirrors">Side Mirrors</option>
                                    <option value="Windshield">Windshield</option>
                                </optgroup>
                                
                                <optgroup label="Interior">
                                    <option value="Dashboard">Dashboard</option>
                                    <option value="Seats">Seats</option>
                                    <option value="Steering Wheel">Steering Wheel</option>
                                    <option value="Airbag Module">Airbag Module</option>
                                    <option value="Climate Control Unit">Climate Control Unit</option>
                                    <option value="Door Panels">Door Panels</option>
                                    <option value="Center Console">Center Console</option>
                                    <option value="Floor Mats">Floor Mats</option>
                                </optgroup>
                                
                                <optgroup label="HVAC System">
                                    <option value="A/C Compressor">A/C Compressor</option>
                                    <option value="A/C Condenser">A/C Condenser</option>
                                    <option value="Heater Core">Heater Core</option>
                                    <option value="Blower Motor">Blower Motor</option>
                                    <option value="Evaporator">Evaporator</option>
                                    <option value="Expansion Valve">Expansion Valve</option>
                                </optgroup>
                                
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn minus-btn">-</button>
                            <input type="number" name="quantity" id="quantity" class="quantity-input" value="1" min="1" required>
                            <button type="button" class="quantity-btn plus-btn">+</button>
                        </div>
                    </div>
                </div>
                
                <div class="price-display" id="price-display">
                    Select a service or part to see the price
                </div>
                
                <!-- Hidden Price Input -->
                <input type="hidden" id="price" name="price">
            </div>
            
            <div class="submit-button">
                <button type="submit" name="submit">
                    <i class="fas fa-paper-plane"></i> Submit Service Request
                </button>
            </div>
        </form>
        
        <div class="footer">
            &copy; <?php echo date('Y'); ?> Audi Service Center. All Rights Reserved.
        </div>
    </div>

    <script>
        // Price data for each service and part
        const servicePrices = {
            // Original Services
            "Tire Change": 500,
            "Mobil Change": 300,
            "Brake Shoe Change": 400,
            "Coolent Change": 350,
            "Brake Issue": 600,
            "Diesel Tank": 450,
            "Mobile Tank": 350,
            "Head Light": 150,
            "Deeper": 1000,
            
            // Engine Parts
            "Engine Control Module": 15000,
            "Timing Belt Kit": 8000,
            "Engine Mounts": 3500,
            "Crankshaft Sensor": 2000,
            "Camshaft": 12000,
            "Pistons": 8000,
            "Connecting Rods": 6000,
            "Oil Pump": 4500,
            "Turbocharger": 25000,
            "Intercooler": 9000,
            
            // Transmission
            "Transmission Assembly": 45000,
            "Clutch Kit": 15000,
            "Flywheel": 12000,
            "Transmission Fluid": 2500,
            "Gear Selector": 5000,
            "DSG Mechatronic Unit": 30000,
            
            // Brake System
            "Brake Pads": 5000,
            "Brake Rotors": 8000,
            "Brake Calipers": 12000,
            "ABS Control Module": 18000,
            "Brake Lines": 3000,
            "Brake Master Cylinder": 7500,
            
            // Suspension & Steering
            "Shock Absorbers": 6000,
            "Struts": 8000,
            "Control Arms": 5000,
            "Tie Rods": 3000,
            "Sway Bar Links": 2000,
            "Ball Joints": 3500,
            "Steering Rack": 16000,
            "Power Steering Pump": 8000,
            "Wheel Bearings": 4000,
            
            // Electrical System
            "Battery": 12000,
            "Alternator": 8000,
            "Starter Motor": 7000,
            "Ignition Coils": 3000,
            "Spark Plugs": 2000,
            "Fuse Box": 5000,
            "Headlight Assembly": 18000,
            "Tail Light Assembly": 12000,
            "Turn Signal Switch": 3500,
            "Window Regulator": 6000,
            "MMI Control Unit": 25000,
            
            // Cooling System
            "Radiator": 11000,
            "Water Pump": 6000,
            "Thermostat": 2500,
            "Cooling Fan": 5000,
            "Coolant Reservoir": 2000,
            "Radiator Hoses": 1500,
            
            // Fuel System
            "Fuel Pump": 9000,
            "Fuel Injectors": 8000,
            "Fuel Filter": 1500,
            "Fuel Pressure Regulator": 3500,
            "Fuel Tank": 15000,
            "Fuel Lines": 4000,
            
            // Exhaust System
            "Catalytic Converter": 22000,
            "Exhaust Manifold": 12000,
            "Muffler": 8000,
            "Oxygen Sensor": 3500,
            "Exhaust Pipes": 6000,
            "DPF Filter": 18000,
            
            // Body Parts
            "Front Bumper": 25000,
            "Rear Bumper": 22000,
            "Hood": 30000,
            "Trunk Lid": 25000,
            "Doors": 35000,
            "Fenders": 18000,
            "Grille": 12000,
            "Side Mirrors": 8000,
            "Windshield": 15000,
            
            // Interior
            "Dashboard": 45000,
            "Seats": 55000,
            "Steering Wheel": 15000,
            "Airbag Module": 20000,
            "Climate Control Unit": 12000,
            "Door Panels": 8000,
            "Center Console": 10000,
            "Floor Mats": 3000,
            
            // HVAC System
            "A/C Compressor": 18000,
            "A/C Condenser": 12000,
            "Heater Core": 15000,
            "Blower Motor": 6000,
            "Evaporator": 14000,
            "Expansion Valve": 4000
        };

        // Reference elements
        const wantField = document.getElementById('want');
        const quantityField = document.getElementById('quantity');
        const priceDisplay = document.getElementById('price-display');
        const priceField = document.getElementById('price');
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');

        function updatePrice() {
            const selectedService = wantField.value;
            const quantity = parseInt(quantityField.value) || 1;

            if (selectedService && servicePrices[selectedService]) {
                const unitPrice = servicePrices[selectedService];
                const totalPrice = unitPrice * quantity;

                // Display price
                priceDisplay.innerHTML = `
                    Item: <span>${selectedService}</span><br>
                    Unit Price: <span>₹${unitPrice.toLocaleString()}</span><br>
                    Quantity: <span>${quantity}</span><br>
                    <div style="font-size: 22px; margin-top: 10px;">
                        Total: <span>₹${totalPrice.toLocaleString()}</span>
                    </div>
                `;

                // Update hidden price field
                priceField.value = totalPrice;
            } else if (selectedService === "Other") {
                priceDisplay.textContent = 'Please contact for custom pricing';
                priceField.value = '0'; // For "Other" option, set price to 0 and update later
            } else {
                priceDisplay.textContent = 'Please select a valid service or part';
                priceField.value = ''; // Clear price if no service is selected
            }
        }

        // Quantity increment/decrement
        minusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityField.value) || 1;
            if (currentValue > 1) {
                quantityField.value = currentValue - 1;
                updatePrice();
            }
        });

        plusBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityField.value) || 1;
            quantityField.value = currentValue + 1;
            updatePrice();
        });

        // Attach event listeners
        wantField.addEventListener('change', updatePrice);
        quantityField.addEventListener('input', updatePrice);

        // Initialize price calculation
        updatePrice();
    </script>
    </form>
</div>
    </div>

    <script>
        // Service level selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Buttons to select service level
            const level1Btn = document.getElementById('level1Btn');
            const level2Btn = document.getElementById('level2Btn');
            const level3Btn = document.getElementById('level3Btn');
            const level4Btn = document.getElementById('level4Btn');
            
            // Back buttons
            const backBtn1 = document.getElementById('backBtn1');
            const backBtn2 = document.getElementById('backBtn2');
            const backBtn3 = document.getElementById('backBtn3');
            const backBtn4 = document.getElementById('backBtn4');

            // Forms
            const serviceSelection = document.getElementById('service-selection');
            const level1Form = document.getElementById('level1Form');
            const level2Form = document.getElementById('level2Form');
            const level3Form = document.getElementById('level3Form');
            const level4Form = document.getElementById('level4Form');

            // Show Level 1 form
            level1Btn.addEventListener('click', function() {
                serviceSelection.style.display = 'none';
                level1Form.style.display = 'block';
            });
            
            // Show Level 2 form
            level2Btn.addEventListener('click', function() {
                serviceSelection.style.display = 'none';
                level2Form.style.display = 'block';
            });
            
            // Show Level 3 form
            level3Btn.addEventListener('click', function() {
                serviceSelection.style.display = 'none';
                level3Form.style.display = 'block';
            });

            // Show Level 4 form
            level4Btn.addEventListener('click', function() {
                serviceSelection.style.display = 'none';
                level4Form.style.display = 'block';
            });
            
            // Back button functionality
            backBtn1.addEventListener('click', function() {
                level1Form.style.display = 'none';
                serviceSelection.style.display = 'block';
            });
            
            backBtn2.addEventListener('click', function() {
                level2Form.style.display = 'none';
                serviceSelection.style.display = 'block';
            });
            
            backBtn3.addEventListener('click', function() {
                level3Form.style.display = 'none';
                serviceSelection.style.display = 'block';
            });

            backBtn4.addEventListener('click', function() {
                level4Form.style.display = 'none';
                serviceSelection.style.display = 'block';
            });
            
            // Set minimum date to today for all date fields
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date1').min = today;
            document.getElementById('date2').min = today;
            document.getElementById('date3').min = today;
            document.getElementById('date4').min = today;

            // First, let's add prices to each service in HTML by modifying the checkbox items
// This JavaScript needs to be added at the end of your existing script section

    
    
});

    </script>
</body>
</html>