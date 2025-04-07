<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
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
                    <label for="name1">Your Name</label>
                    <input type="text" id="name1" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>

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
            <form action="php/appoiintment.php" method="post" id="level2AppointmentForm">
                <input type="hidden" name="service_level" value="Level 2">
                <div class="form-group">
                    <label for="service2">Select Vehicle Type</label>
                    <select id="service2" name="service" required>
                        <option value="">--Select Vehicle Type--</option>
                        <option value="Car Maintenance">Car Maintenance</option>
                        <option value="Bike Servicing">Bike Servicing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date2">Preferred Date</label>
                    <input type="date" id="date2" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time2">Preferred Time</label>
                    <input type="time" id="time2" name="time" required>
                </div>

                <div class="form-group">
                    <label for="name2">Your Name</label>
                    <input type="text" id="name2" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="vehicle2">Vehicle Number</label>
                    <input type="text" id="vehicle2" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>

                <div class="form-group">
                    <label for="phone_number2">Phone Number</label>
                    <input type="text" id="phone_number2" name="phone_number" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="comments2">Additional Comments</label>
                    <textarea id="comments2" name="comments" rows="3" placeholder="Any specific requests or concerns?" class="form-control"></textarea>
                </div>

                <div class="button-container">
                    <button type="submit" class="submit-btn" name="submit">Schedule Level 2 Service</button>
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
            <form action="php/appoiintment.php" method="post" id="level3AppointmentForm">
                <input type="hidden" name="service_level" value="Level 3">
                <div class="form-group">
                    <label for="service3">Select Vehicle Type</label>
                    <select id="service3" name="service" required>
                        <option value="">--Select Vehicle Type--</option>
                        <option value="Car Maintenance">Car Maintenance</option>
                        <option value="Bike Servicing">Bike Servicing</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date3">Preferred Date</label>
                    <input type="date" id="date3" name="date" required>
                </div>

                <div class="form-group">
                    <label for="time3">Preferred Time</label>
                    <input type="time" id="time3" name="time" required>
                </div>

                <div class="form-group">
                    <label for="name3">Your Name</label>
                    <input type="text" id="name3" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-group">
                    <label for="vehicle3">Vehicle Number</label>
                    <input type="text" id="vehicle3" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>

                <div class="form-group">
                    <label for="phone_number3">Phone Number</label>
                    <input type="text" id="phone_number3" name="phone_number" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="comments3">Additional Comments</label>
                    <textarea id="comments3" name="comments" rows="3" placeholder="Any specific requests or concerns?" class="form-control"></textarea>
                </div>

                <div class="button-container">
                    <button type="submit" class="submit-btn" name="submit">Schedule Level 3 Service</button>
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
            
            // Back buttons
            const backBtn1 = document.getElementById('backBtn1');
            const backBtn2 = document.getElementById('backBtn2');
            const backBtn3 = document.getElementById('backBtn3');
            
            // Forms
            const serviceSelection = document.getElementById('service-selection');
            const level1Form = document.getElementById('level1Form');
            const level2Form = document.getElementById('level2Form');
            const level3Form = document.getElementById('level3Form');
            
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
            
            // Set minimum date to today for all date fields
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date1').min = today;
            document.getElementById('date2').min = today;
            document.getElementById('date3').min = today;
        });
    </script>
</body>
</html>