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
                    <span>Basic Maintenance</span>
                </button>
                <button class="service-level-btn level-2-btn" id="level2Btn">
                    <i class="fas fa-tools"></i>
                    Level 2 Service
                    <span>Intermediate Service</span>
                </button>
                <button class="service-level-btn level-3-btn" id="level3Btn">
                    <i class="fas fa-cogs"></i>
                    Level 3 Service
                    <span>Comprehensive Service</span>
                </button>
                <button class="service-level-btn level-4-btn" id="level4Btn">
                    <i class="fas fa-cogs"></i>
                    Level 4 Service
                    <span>Customize Service</span>
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
    <form action="php/apppoiintment.php" method="post" id="level4AppointmentForm">
        <input type="hidden" name="service_level" value="Level 4">
        <!-- Rest of the form remains the same -->
        <div class="form-group">
            <label for="service4">Select Vehicle Type</label>
            <select id="service4" name="service" required>
                <option value="">--Select Vehicle Type--</option>
                <option value="Car Maintenance">Car Maintenance</option>
                <option value="Bike Servicing">Bike Servicing</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date4">Preferred Date</label>
            <input type="date" id="date4" name="date" required>
        </div>

        <div class="form-group">
            <label for="time4">Preferred Time</label>
            <input type="time" id="time4" name="time" required>
        </div>

        <div class="form-group">
            <label for="name4">Owner Name</label>
            <input type="text" id="name4" name="name" placeholder="Enter your name" required>
        </div>

        <div class="form-group">
            <label for="vehicle4">Vehicle Number</label>
            <input type="text" id="vehicle4" name="vehicle" placeholder="Enter your vehicle number" required>
        </div>
        <div class="form-group">
            <label for="engine4">Engine Number</label>
            <input type="text" id="engine4" name="engine" placeholder="Enter your engine number" required>
        </div>

        <div class="form-group">
            <label for="chassis4">Chassis Number</label>
            <input type="text" id="chassis4" name="chassis" placeholder="Enter your chassis number" required>
        </div>

        <div class="form-group">
            <label for="phone_number4">Phone Number</label>
            <input type="text" id="phone_number4" name="phone_number" placeholder="Enter your phone number" required>
        </div>

        <!-- Replace the existing service-details div in the Level 4 form with this updated version -->

<div class="service-details">
    <h3>Select Services:</h3>
    
    <!-- Car Services -->
    <h4 style="margin-top: 15px; margin-bottom: 10px; color: #4361ee;">Car Services</h4>
    <ul style="list-style-type: none; padding-left: 0;">
        <li>
            <input type="checkbox" id="service_oil_change" name="custom_services[]" value="Oil & Filter Change">
            <label for="service_oil_change">Oil & Filter Change</label>
        </li>
        <li>
            <input type="checkbox" id="service_tire_rotation" name="custom_services[]" value="Tire Rotation">
            <label for="service_tire_rotation">Tire Rotation</label>
        </li>
        <li>
            <input type="checkbox" id="service_brake_inspection" name="custom_services[]" value="Brake Inspection & Service">
            <label for="service_brake_inspection">Brake Inspection & Service</label>
        </li>
        <li>
            <input type="checkbox" id="service_wheel_alignment" name="custom_services[]" value="Wheel Alignment">
            <label for="service_wheel_alignment">Wheel Alignment</label>
        </li>
        <li>
            <input type="checkbox" id="service_battery_service" name="custom_services[]" value="Battery Service & Replacement">
            <label for="service_battery_service">Battery Service & Replacement</label>
        </li>
        <li>
            <input type="checkbox" id="service_ac_service" name="custom_services[]" value="AC Service & Repair">
            <label for="service_ac_service">AC Service & Repair</label>
        </li>
        <li>
            <input type="checkbox" id="service_trans_fluid" name="custom_services[]" value="Transmission Fluid Change">
            <label for="service_trans_fluid">Transmission Fluid Change</label>
        </li>
        <li>
            <input type="checkbox" id="service_engine_diag" name="custom_services[]" value="Engine Diagnostics">
            <label for="service_engine_diag">Engine Diagnostics</label>
        </li>
        <li>
            <input type="checkbox" id="service_fuel_inj" name="custom_services[]" value="Fuel Injection Cleaning">
            <label for="service_fuel_inj">Fuel Injection Cleaning</label>
        </li>
        <li>
            <input type="checkbox" id="service_power_steering" name="custom_services[]" value="Power Steering Fluid Change">
            <label for="service_power_steering">Power Steering Fluid Change</label>
        </li>
        <li>
            <input type="checkbox" id="service_diff_fluid" name="custom_services[]" value="Differential Fluid Change">
            <label for="service_diff_fluid">Differential Fluid Change</label>
        </li>
        <li>
            <input type="checkbox" id="service_spark_plug" name="custom_services[]" value="Spark Plug Replacement">
            <label for="service_spark_plug">Spark Plug Replacement</label>
        </li>
        <li>
            <input type="checkbox" id="service_electrical" name="custom_services[]" value="Electrical System Check">
            <label for="service_electrical">Electrical System Check</label>
        </li>
        <li>
            <input type="checkbox" id="service_cooling_system" name="custom_services[]" value="Cooling System Service">
            <label for="service_cooling_system">Cooling System Service</label>
        </li>
        <li>
            <input type="checkbox" id="service_suspension" name="custom_services[]" value="Suspension Inspection & Repair">
            <label for="service_suspension">Suspension Inspection & Repair</label>
        </li>
        <li>
            <input type="checkbox" id="service_exhaust" name="custom_services[]" value="Exhaust System Check">
            <label for="service_exhaust">Exhaust System Check</label>
        </li>
    </ul>
    
    <!-- Bike Services -->
    <h4 style="margin-top: 20px; margin-bottom: 10px; color: #4361ee;">Bike Services</h4>
    <ul style="list-style-type: none; padding-left: 0;">
        <li>
            <input type="checkbox" id="service_bike_oil" name="custom_services[]" value="Bike Engine Oil Change">
            <label for="service_bike_oil">Engine Oil Change</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_chain" name="custom_services[]" value="Chain Cleaning & Lubrication">
            <label for="service_bike_chain">Chain Cleaning & Lubrication</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_brake" name="custom_services[]" value="Brake Pad Replacement">
            <label for="service_bike_brake">Brake Pad Replacement</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_tune" name="custom_services[]" value="Bike Engine Tune-up">
            <label for="service_bike_tune">Engine Tune-up</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_tire" name="custom_services[]" value="Tire Replacement">
            <label for="service_bike_tire">Tire Replacement</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_clutch" name="custom_services[]" value="Clutch Adjustment">
            <label for="service_bike_clutch">Clutch Adjustment</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_carb" name="custom_services[]" value="Carburetor Cleaning">
            <label for="service_bike_carb">Carburetor Cleaning</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_battery" name="custom_services[]" value="Bike Battery Replacement">
            <label for="service_bike_battery">Battery Replacement</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_wheel" name="custom_services[]" value="Wheel Alignment & Balancing">
            <label for="service_bike_wheel">Wheel Alignment & Balancing</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_electrical" name="custom_services[]" value="Electrical System Check">
            <label for="service_bike_electrical">Electrical System Check</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_full" name="custom_services[]" value="Full Bike Service">
            <label for="service_bike_full">Full Bike Service</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_suspension" name="custom_services[]" value="Suspension Tuning">
            <label for="service_bike_suspension">Suspension Tuning</label>
        </li>
        <li>
            <input type="checkbox" id="service_bike_filters" name="custom_services[]" value="Air Filter Replacement">
            <label for="service_bike_filters">Air Filter Replacement</label>
        </li>
    </ul>
    
    <!-- Other Services -->
    <h4 style="margin-top: 20px; margin-bottom: 10px; color: #4361ee;">Other Services</h4>
    <ul style="list-style-type: none; padding-left: 0;">
        <li>
            <input type="checkbox" id="service_detailing" name="custom_services[]" value="Vehicle Detailing">
            <label for="service_detailing">Vehicle Detailing</label>
        </li>
        <li>
            <input type="checkbox" id="service_paint" name="custom_services[]" value="Paint Touch-up">
            <label for="service_paint">Paint Touch-up</label>
        </li>
        <li>
            <input type="checkbox" id="service_polish" name="custom_services[]" value="Polish & Wax">
            <label for="service_polish">Polish & Wax</label>
        </li>
        <li>
            <input type="checkbox" id="service_inspection" name="custom_services[]" value="Pre-purchase Inspection">
            <label for="service_inspection">Pre-purchase Inspection</label>
        </li>
        <li>
            <input type="checkbox" id="service_custom" name="custom_services[]" value="Custom Service">
            <label for="service_custom">Custom Service (Please specify in comments)</label>
        </li>
    </ul>
</div>

        <div class="form-group">
            <label for="comments4">Additional Comments</label>
            <textarea id="comments4" name="comments" rows="3" placeholder="Any specific requests or concerns?" class="form-control"></textarea>
        </div>

        <div class="button-container">
            <button type="submit" class="submit-btn" name="submit">Schedule Level 4 Service</button>
        </div>
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
        });
    </script>
</body>
</html>