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
    <title>Vehicle Servicing System</title>
    <link rel="icon" href="photo/Untitled-removebg-preview.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
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
            /* position: sticky; */
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 1rem;
            backdrop-filter: blur(2px);
            transition: top 0.3s;
        }

        .hidden-header {
            top: -100px;
        }
        .left-header {
            display: flex;
            align-items: center;
        }
        .left-header input[type="text"] {
            padding: 8px;
            border-radius: 4px;
            border: none;
            outline: none;
            font-size: 14px;
        }
        .right-header {
            display: flex;
            gap: 15px;
        }
        .right-header a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 15px;
            background: linear-gradient(145deg,rgb(94, 165, 209),rgb(162, 96, 198));
            border-radius: 4px;
        }
        .right-header a:hover {
            background: linear-gradient(145deg,rgb(68, 152, 42),rgb(83, 165, 144));
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            width: 90px;
            height: 90px;
            margin-right: 10px;
        }
        .auth-buttons {
            display: flex;
            gap: 10px;
        }
        .auth-buttons button {
            background-color: white;
            color: #0073e6;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .auth-buttons button:hover {
            background-color: #005bb5;
            color: white;
        }
        h1 {
            color: #0073e6;
        }
        section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem auto;
            max-width: 800px;
            padding: 1rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(2px);
            transition: top 0.3s;
        }
        .auto-typing {
            font-size: 1.5rem;
            font-weight: bold;
            color:blue;
            /* background: linear-gradient(145deg,rgb(68, 152, 42),rgb(83, 165, 144)); */
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        .auto-typing span {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #0073e6;
            animation: typing 4s steps(20) infinite alternate;
        }
        .scroll-section {
            margin: 2rem auto;
            max-width: 800px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            backdrop-filter: blur(2px);
            transition: top 0.3s;
        }
        .scroll-item {
            width: 200px;
            height: 150px;
            background-color:rgb(32, 140, 241);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            border-radius: 8px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease-out;
        }
        .scroll-item img {
    width: 150px;  /* Set the desired width for the logos */
    height: 100px; /* Set the desired height for the logos */
    object-fit: contain; /* Ensure the aspect ratio is maintained */
    border-radius: 8px;
}

        .scroll-item.show {
            opacity: 1;
            transform: translateY(0);
        }

        .feedback-section {
        margin: 2rem auto;
        max-width: 800px;
        padding: 1rem;
        text-align: center;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .feedback-container {
        position: relative;
        height: 150px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .feedback-item {
        font-size: 1.2rem;
        color: #333;
        padding: 10px;
        opacity: 0;
        transform: translateY(50px);
        animation: scrollFeedback 5s linear infinite;
    }
    @keyframes scrollFeedback {
        0% { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(-50px); }
    }        
    footer {
    background-color: #333;
    color: #fff;
    padding: 2rem 0;
    font-size: 0.9rem;
    backdrop-filter: blur(2px);
    transition: top 0.3s;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.footer-section {
    flex: 1 1 200px;
    margin: 1rem;
}

.footer-section h3 {
    border-bottom: 2px solid #0073e6;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section ul li a {
    color: #fff;
    text-decoration: none;
}

.footer-section ul li a:hover {
    text-decoration: underline;
}

.social-icons a {
    display: inline-block;
    margin-right: 10px;
}

.social-icons img {
    width: 24px;
    height: 24px;
}

.footer-bottom {
    text-align: center;
    margin-top: 1rem;
    border-top: 1px solid #444;
    padding-top: 1rem;
}
.feedback-button {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background: linear-gradient(145deg,rgb(94, 165, 209),rgb(162, 96, 198));
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            z-index: 1000;
            backdrop-filter: blur(2px);
            transition: top 0.3s;
        }
        .feedback-button:hover {
            background: linear-gradient(145deg,rgb(68, 152, 42),rgb(83, 165, 144));
        }

        /* .call-support {
            position: fixed;
            right: 20px;
            bottom: 80px;
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .call-support:hover {
            background-color: #005bb5;
        } */

        .chatbot {
            position: fixed;
            bottom: 140px;
            right: 20px;
            background: linear-gradient(145deg,rgb(94, 165, 209),rgb(162, 96, 198));
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .chatbot:hover {
            background: linear-gradient(145deg,rgb(68, 152, 42),rgb(83, 165, 144));
        }
        .chatbot-popup {
            position: fixed;
            bottom: 200px;
            right: 20px;
            width: 300px;
            height: 400px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 1000;
        }
        .chatbot-header {
            background-color: #0073e6;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .chatbot-messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
        }
        .chatbot-input {
            display: flex;
            border-top: 1px solid #ccc;
        }
        .chatbot-input input {
            flex: 1;
            border: none;
            padding: 10px;
            outline: none;
        }
        .chatbot-input button {
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .chatbot-input button:hover {
            background-color: #005bb5;
        }
        
        .user-menu {
    position: relative;
    display: inline-block;
}

.user-email {
    color: white;
    text-decoration: none;
    font-size: 14px;
    padding: 8px 15px;
    background: linear-gradient(145deg, rgb(94, 165, 209), rgb(162, 96, 198));
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    transition: background 0.3s ease;
}

.user-email:hover {
    background: linear-gradient(145deg, rgb(68, 152, 42), rgb(83, 165, 144));
}

.logout-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgba(0, 0, 0, 0.8);
    border-radius: 4px;
    padding: 5px 0;
    min-width: 100px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.logout-menu a {
    color: white;
    text-decoration: none;
    padding: 8px 15px;
    display: block;
    background: linear-gradient(145deg, rgb(255, 94, 94), rgb(198, 68, 68));
    border-radius: 4px;
}

.logout-menu a:hover {
    background: linear-gradient(145deg, rgb(165, 42, 42), rgb(144, 68, 68));
}

/* Show logout when hovering over email */
.user-menu:hover .logout-menu {
    display: block;
}

h1 {
            text-align: center;
            color: var(--dark);
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #7f8c8d;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .data-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-x: auto;
        }
        
        .message {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .message.success {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success);
        }
        
        .message.error {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger);
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }
        
        th {
            background-color: var(--light);
            color: var(--dark);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .status-pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .vehicle-type {
            font-weight: 600;
        }
        
        .vehicle-number {
            color: var(--primary);
            font-family: monospace;
            font-size: 14px;
            letter-spacing: 1px;
        }
        
        .date-display {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .price-display {
            font-weight: bold;
            color: var(--dark);
        }
        
        .button-container {
            display: flex;
            gap: 5px;
        }
        
        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .accept {
            background-color: var(--success);
            color: white;
        }
        
        .accept:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
        }
        
        .decline {
            background-color: var(--danger);
            color: white;
        }
        
        .decline:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        
        .no-records {
            text-align: center;
            padding: 40px 0;
            color: #7f8c8d;
            font-size: 18px;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 0;
        }
        
        .empty-state i {
            font-size: 60px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }
        
        .empty-state p {
            font-size: 18px;
            color: #7f8c8d;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            th, td {
                padding: 8px;
            }
            
            .container {
                width: 95%;
                padding: 10px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            /* Stack the button container on small screens */
            .button-container {
                flex-direction: column;
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
    <div class="logo">
            <img src="photo/Blue_Gold_Minimalist_Car_Showroom_Logo-removebg-preview.png" alt="Vehicle Logo">
            
        </div>
        <div class="right-header">
    <a href="../home.php">Home</a>
    <a href="blog.php">Blog</a>
    <a href="../appointment.html">Appointment</a>
    <div class="user-menu">
        <a href="#" class="user-email"><?php echo htmlspecialchars($_SESSION['email']); ?></a>
        <div class="logout-menu">
            <a href="php/orderdetails.php">Order Details</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>
</div>

    </header>
   




    <!-- body section  -->

    <?php
        include 'signup.php';
        error_reporting(E_ALL);

        // Fetch records from the database
        $query = "SELECT * FROM service where EMAIL='" . mysqli_real_escape_string($con, $_SESSION['email']) . "'";
        $run = mysqli_query($con, $query);
        $count = mysqli_num_rows($run);

        if ($count > 0) {
        ?>
        <div class="data-container">
            <table id="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Vehicle</th>
                        <th>Contact Info</th>
                        <th>Service Details</th>
                        <th>Date & Location</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php while ($call = mysqli_fetch_assoc($run)) { ?>
                        <tr id="row-<?php echo $call['ID']; ?>">
                            <td>#<?php echo htmlspecialchars($call['ID']); ?></td>
                            <td>
                                <div class="vehicle-type"><?php echo htmlspecialchars($call['V_TYPE']); ?></div>
                                <div class="vehicle-number"><?php echo htmlspecialchars($call['V_NUMBER']); ?></div>
                            </td>
                            <td>
                                <div><?php echo htmlspecialchars($call['EMAIL']); ?></div>
                                <div><?php echo htmlspecialchars($call['PHONE']); ?></div>
                            </td>
                            <td>
                                <div><strong>Service:</strong> <?php echo htmlspecialchars($call['WANT']); ?></div>
                                <div><strong>Qty:</strong> <?php echo htmlspecialchars($call['QUANTITY']); ?></div>
                                <div class="price-display">Price: <span class="price-value"><?php echo htmlspecialchars($call['PRICE']); ?></span></div>
                            </td>
                            <td>
                                <div class="date-display">
                                    <i class="far fa-calendar-alt"></i> 
                                    <span class="date-value"><?php echo htmlspecialchars($call['DATE']); ?></span>
                                </div>
                                <div><small><?php echo htmlspecialchars($call['ADDRESS']); ?></small></div>
                            </td>
                           
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div id="empty-state" class="empty-state" style="display: none;">
                <i class="fas fa-clipboard-check"></i>
                <p>All service requests have been processed</p>
            </div>
        </div>
        <?php
        } else {
        ?>
        <div class="data-container">
            <div class="empty-state">
                <i class="fas fa-clipboard-check"></i>
                <p>No service requests available at this time</p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>

  <footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Helping</h3>
            <ul>
                <li>In this platform we add local gaurage owner and help them to take their bussiness online</li>
                
            </ul>
        </div>
        <div class="footer-section">
            <h3>Services</h3>
            <ul>
                <li><a href="appointment.html">Car Maintenance</a></li>
                <li><a href="appointment.html">Bike Servicing</a></li>
                <li><a href="emergencyrepair.html">Emergency Repairs</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Email: merigaddi0008@gmail.com</p>
            <p>Phone: +91 8340300338</p>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="https://www.facebook.com/profile.php?id=61573648584570"><img src="facebook-icon.png" alt="Facebook"></a>
                <a href="https://x.com/merigaddi0008"><img src="twitter-icon.png" alt="Twitter"></a>
                <a href="https://www.threads.net/@merigaddi0008"><img src="twitter-icon.png" alt="Thread"></a>
                <a href="https://www.instagram.com/merigaddi0008?igsh=MXg0OWhjc3ExMThzbw=="><img src="instagram-icon.png" alt="Instagram"></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Vehicle Servicing System. All rights reserved.</p>
    </div>
</footer>


</body>
</html>
