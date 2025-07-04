<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch posts
$sql = "SELECT NAME,EMAIL,IMAGE,FEEDBACK FROM feedback";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Servicing System</title>
    <link rel="icon" href="photo/Untitled-removebg-preview.png">
    <link rel="icon" href="photo/Untitled-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            position: fixed; /* Changed from sticky to fixed */
            top: 0;
            width: 100%; /* Ensure full width */
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease; /* Added transition for smooth hide/show */
        }
        
        /* Class to hide header when scrolling up */
        header.hide {
            transform: translateY(-100%);
        }
        /* Add top padding to body to compensate for fixed header */
        body {
            padding-top: 90px; /* Adjust this value based on your header height */
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
            transition: all 0.9s ease;
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
            color: white;
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

        /* IMPROVED FEEDBACK SECTION STYLING */
        .feedback-section {
            margin: 2rem auto;
            max-width: 800px;
            padding: 1.5rem;
            text-align: center;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .feedback-section h2 {
            color: #0073e6;
            margin-bottom: 1.5rem;
            font-size: 28px;
            position: relative;
            display: inline-block;
        }

        .feedback-section h2:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, #0073e6, transparent);
            left: 25%;
            bottom: -10px;
        }

        .feedback-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            scrollbar-width: thin;
            scrollbar-color: #0073e6 #f0f0f0;
        }

        .feedback-container::-webkit-scrollbar {
            width: 8px;
        }

        .feedback-container::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .feedback-container::-webkit-scrollbar-thumb {
            background-color: #0073e6;
            border-radius: 10px;
        }

        .feedback-item {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            text-align: left;
            transition: all 0.3s ease;
            border-left: 4px solid #0073e6;
            animation: fadeIn 0.5s ease-in;
            position: relative;
            overflow: hidden;
        }

        .feedback-item:before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 60px;
            color: rgba(0, 115, 230, 0.1);
            font-family: Georgia, serif;
            line-height: 1;
        }

        .feedback-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 115, 230, 0.15);
        }

        .feedback-item.highlight {
            background-color: #e6f3ff;
            border-left: 4px solid #0073e6;
            transform: scale(1.02);
        }

        .feedback-author {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-left: 15px;
        }

        .feedback-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid #0073e6;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .feedback-author span {
            font-weight: bold;
            color: #0073e6;
            font-size: 1.1rem;
        }

        .feedback-item p {
            margin: 0;
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
            padding-left: 15px;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
<style>
.carousel-container {
    overflow: hidden;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    border-radius: 12px;
}

.carousel-track {
    display: flex;
    width: max-content;
    animation: scroll 25s linear infinite;
}

.carousel-item {
    flex: 0 0 auto;
    width: 300px;
    margin: 20px;
    background: #f4f4f4;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.carousel-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 10px;
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
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

    </style>
</head>
<c>
  <video class="background-video" id="bgVideo" autoplay muted loop>
        <source src="video/istockphoto-1680698591-640_adpp_is.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <header id="site-header">
        <div class="header-container">
            <div class="logo">
                <img src="photo/Blue_Gold_Minimalist_Car_Showroom_Logo-removebg-preview.png" alt="Vehicle Logo">
            </div>
            <div class="right-header">
                <a href="home.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
                <a href="php/blog.php" class="nav-link"><i class="fas fa-blog"></i> Blog</a>
                <a href="appointment.php" class="accent-link"><i class="fas fa-calendar-check"></i> Book Appointment</a>
                <div class="user-menu">
                    <div class="user-email">
                        <i class="fas fa-user-circle user-icon"></i>
                        <?php echo htmlspecialchars($_SESSION['email']); ?>
                        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                    </div>
                    <div class="logout-menu">
                        <a href="php/orderdetails.php" class="logout-menu-item">
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
    <section>
        <div class="auto-typing">
       <center> 
            <h2>Register your</h2>
            <p><span id="typing">Car</span></p>
            <h6>If you have any issue complent
             here to raise your ticket </h6>
        </center>
        </div>
        <div class="image-container">
            <img src="photo/pngtree-auto-repair-vector-png-image_6888531.png" alt="Vehicle Servicing System">
        </div>
    </section>
    <center><h2>Order Sphere here</h2></center>
    <section class="scroll-section">
        <div class="scroll-item"><a href="audirequest.php"><img src="servicelogo/audi.png" alt=""></a></div>
        <div class="scroll-item"><a href="hondarequest.php"><img src="servicelogo/Honda.png" alt=""></a></div>
        <div class="scroll-item"><a href="bmwrequest.php"><img src="servicelogo/bmw.png" alt=""></a></div>
        <div class="scroll-item"><a href="fordrequest.php"><img src="servicelogo/ford.png" alt=""></a></div>
        <div class="scroll-item"><a href="hundayrequest.php"><img src="servicelogo/hyundai.png" alt=""></a></div>
        <div class="scroll-item"><a href="kiarequest.php"><img src="servicelogo/Kia.png" alt=""></a></div>
        <div class="scroll-item"><a href="suzukirequest.php"><img src="servicelogo/suzuki.png" alt=""></a></div>
        <div class="scroll-item"><a href="mahendrarequest.php"><img src="servicelogo/mahindra.png" alt=""></a></div>
        <div class="scroll-item"><a href="mercidiserequest.php"><img src="servicelogo/mercedes.png" alt=""></a></div>
        <div class="scroll-item"><a href="mgrequest.php"><img src="servicelogo/MG.png" alt=""></a></div>
        <div class="scroll-item"><a href="nisanrequest.php"><img src="servicelogo/nissan.png" alt=""></a></div>
        <div class="scroll-item"><a href="tatarequest.php"><img src="servicelogo/tata.png" alt=""></a></div>
        <div class="scroll-item"><a href="tvsrequest.php"><img src="servicelogo/tvs.png" alt=""></a></div>
        <div class="scroll-item"><a href="tyotarequest.php"><img src="servicelogo/toyota.png" alt=""></a></div>
        <div class="scroll-item"><a href="herorequest.php"><img src="servicelogo/hero.png" alt=""></a></div>
    </section>
    <button class="feedback-button" onclick="location.href='feedbackhome.html'">Feedback</button>
    
    <!-- <button class="chatbot" onclick="toggleChatbot()">💬</button>
    <div class="chatbot-popup" id="chatbotPopup">
        <div class="chatbot-header">Chat Support</div>
        <div class="chatbot-messages" id="chatbotMessages"></div>
        <div class="chatbot-input">
            <input type="text" id="chatbotInput" placeholder="Type a message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div> -->
    <script>
        const chatbotPopup = document.getElementById("chatbotPopup");
        const chatbotMessages = document.getElementById("chatbotMessages");
        const chatbotInput = document.getElementById("chatbotInput");

        function toggleChatbot() {
            chatbotPopup.style.display = chatbotPopup.style.display === "flex" ? "none" : "flex";
        }

        function sendMessage() {
            const message = chatbotInput.value.trim();
            if (message) {
                const userMessage = document.createElement("div");
                userMessage.textContent = message;
                userMessage.style.marginBottom = "10px";
                userMessage.style.textAlign = "right";
                chatbotMessages.appendChild(userMessage);
                chatbotInput.value = "";

                setTimeout(() => {
                    const botMessage = document.createElement("div");
                    botMessage.textContent = "Hello ! Thank you for choosing for.";
                    botMessage.style.marginBottom = "10px";
                    botMessage.style.textAlign = "left";
                    chatbotMessages.appendChild(botMessage);
                    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
                }, 1000);
            }
        }
        
        // Add scroll direction detection
        let lastScrollTop = 0;
        const header = document.getElementById('site-header');
        
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Make sure we've scrolled at least a certain amount to avoid flickering
            if (Math.abs(lastScrollTop - scrollTop) <= 5)
                return;
                
            // If scrolling down, hide header
            // If scrolling up or at the top of the page, show header
            if (scrollTop > lastScrollTop && scrollTop > header.offsetHeight) {
                // Scrolling down
                header.classList.add('hide');
            } else {
                // Scrolling up or at top
                header.classList.remove('hide');
            }
            
            lastScrollTop = scrollTop;
        }, false);
    </script>
    <script>
        const scrollItems = document.querySelectorAll(".scroll-item");

        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                } else {
                    entry.target.classList.remove("show");
                }
            });
        }, { threshold: 0.5 });

        scrollItems.forEach(item => scrollObserver.observe(item));

        const words = ["HERO","HONDA","MAHINDRA","SUZUKI","SKODA","HONDA","KIA","HYUNDAI","BMW","JAGUAR","MERCIDIES","LAMBORGINI","TOYOTA"];
        let i = 0;
        const typingElement = document.getElementById("typing");

        function autoType() {
            typingElement.textContent = words[i];
            i = (i + 1) % words.length;
        }

        setInterval(autoType, 2000);
    </script>

<<section class="feedback-section">
<h2 style="text-align:center;">What Our Customers<br> <strong>Say!</strong></h2>
    <div class="feedback-container">
        <?php
        $con = mysqli_connect('localhost', 'root', '', 'final');
        $result = mysqli_query($con, "SELECT * FROM feedback ORDER BY id DESC");

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="feedback-item">';
                echo '<div class="feedback-author">';

                $imagePath = !empty($row['IMAGE']) ? 'php/uploads/' . htmlspecialchars($row['IMAGE']) : 'photo/user-default.png';
                echo '<img src="' . $imagePath . '" alt="User" width="100" height="100" style="object-fit: cover; border-radius: 50%;">';

                echo '<span>' . htmlspecialchars($row['NAME']) . '</span>';
                echo '</div>';
                echo '<p>' . htmlspecialchars($row['FEEDBACK']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No feedback available yet. Be the first to share your experience!</p>';
        }
        ?>
    </div>
</section>
<script>
    // This script handles the animation of feedback items
document.addEventListener("DOMContentLoaded", function() {
    const feedbackItems = document.querySelectorAll('.feedback-item');
    
    // Add animation delay to each feedback item for a staggered effect
    feedbackItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.2}s`;
    });
    
    // Optional: Add automatic cycling of feedback items if there are many
    if (feedbackItems.length > 3) {
        let currentIndex = 0;
        setInterval(() => {
            feedbackItems.forEach(item => item.classList.remove('highlight'));
            feedbackItems[currentIndex].classList.add('highlight');
            
            // Auto-scroll to the highlighted item
            feedbackItems[currentIndex].scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            currentIndex = (currentIndex + 1) % feedbackItems.length;
        }, 5000);
    }
});
</script>
  <!-- footer section -->
  <footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>Providing top-notch vehicle servicing solutions with a focus on customer satisfaction and quality.</p>
        </div>
        <div class="footer-section">
            <h3>Helping</h3>
            <ul>
                <li>In this platform we add local gaurage owner and help them to take their bussiness online</li>
                
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p>Electronic City Phase 1<br>Banglore, India 560100</p>
            <p>Email: merigaddi0008@gmail.com</p>
            <p>Phone: +91 8340300338</p>
        </div>
        <div class="footer-section">
    <h3>Follow Us</h3>
    <div class="social-icons">
        <a href="https://www.facebook.com/profile.php?id=61573648584570" class="facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://x.com/merigaddi0008" class="twitter"><i class="fab fa-twitter"></i></a>
        <a href="https://www.threads.net/@merigaddi0008" class="threads"><i class="fab fa-threads"></i></a>
        <a href="https://www.instagram.com/merigaddi0008?igsh=MXg0OWhjc3ExMThzbw==" class="instagram"><i class="fab fa-instagram"></i></a>
    </div>
</div>
        
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Vehicle Servicing System. All rights reserved.</p>
    </div>
</footer>
</div>
</body>
</html>