<?php
// Fetch posts from the database (assuming you have a database connection here)
// Sample connection (make sure to update with your actual credentials)
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
         /* Blue button styles for signup and signin */
    .nav-link {
        background: #0073e6 !important; /* Blue color */
        color: white !important;
        border: none !important;
        transition: background 0.3s ease, transform 0.3s ease !important;
    }
    
    .nav-link:hover {
        background: #005bb5 !important; /* Darker blue on hover */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            color: white;
        }
        
        .logout-menu-item.danger:hover {
            background-color: rgba(247, 37, 133, 0.05);
        }
        
        /* Show logout when hovering over email */
        .user-menu:hover .logout-menu {
            display: block;
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
            color:rgb(2, 15, 250);
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
            background-color: #0073e6;
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
        .scroll-item.show {
            opacity: 1;
            transform: translateY(0);
        }

        .main-content {
            display: flex;
            margin-top: 20px;
        }

        #posts-container {
            width: 75%;
        }

        .sidebar {
            width: 25%;
            padding: 20px;
            background-color: #e9e9e9;
            margin-left: 20px;
        }

        .sidebar h3 {
            margin-bottom: 10px;
        }

        #addPostForm input, #addPostForm textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        #addPostForm button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
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

        /* UPDATED SOCIAL ICONS STYLING */
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #222;
            color: white;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            transform: translateY(-5px);
        }

        .social-icons a.facebook:hover {
            background: #3b5998;
        }

        .social-icons a.twitter:hover {
            background: #1da1f2;
        }

        .social-icons a.instagram:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        }

        .social-icons a.threads:hover {
            background: #000;
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
            cursor: pointer;
            background-color: #0073e6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            border-radius: 8px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease-out;
            overflow: hidden; /* Prevents images from overflowing */
        }

        .scroll-item.show {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-section img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures images fit well within the container */
            border-radius: 8px; /* Optional: to round corners of images */
        }

        /* Footer Map Styling */
        .footer-map {
            flex: 1 1 200px;
            margin: 1rem;
        }
        
        .footer-map iframe {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>
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
                <a href="signup.html" class="nav-link"><i class="fas fa-user-plus"></i> Signup</a>
                <a href="login.html" class="nav-link"><i class="fas fa-sign-in-alt"></i> SignIn</a>
                
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
    <!-- Replace the current scroll-section with this updated version -->
<section class="scroll-section">
    <div class="carousel-container">
        <div class="carousel-arrow left-arrow" onclick="moveCarousel(-1); resetAutoScroll();">&#10094;</div>
        <div class="carousel-content">
            <div class="carousel-item active">
                <div class="service-card">
                    <img src="photo\Engine Service.jpg" alt="Engine Service">
                    <div class="service-info">
                        <h3>Engine Service</h3>
                        <p>Our comprehensive engine service includes thorough inspection, oil change, filter replacement, and performance optimization to ensure your vehicle runs smoothly and efficiently.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="service-card">
                    <img src="photo\Brake System.jpg" alt="Brake System">
                    <div class="service-info">
                        <h3>Brake System Maintenance</h3>
                        <p>Safety comes first with our brake system maintenance service. Our technicians provide complete brake pad replacement, rotor resurfacing, and fluid checks.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="service-card">
                    <img src="photo\Electrical Diagnostics.jpg" alt="Electrical Diagnostics">
                    <div class="service-info">
                        <h3>Electrical Diagnostics</h3>
                        <p>Using advanced diagnostic equipment, our experts can identify and resolve all electrical issues in your vehicle, from battery testing to complex ECU problems.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="service-card">
                    <img src="photo\Tire Services.jpg" alt="Tire Services">
                    <div class="service-info">
                        <h3>Tire Services</h3>
                        <p>Complete tire care including rotation, balancing, alignment, and replacement. We carry a wide range of premium tires for all vehicle types.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="service-card">
                    <img src="photo\Air Conditioning.jpg" alt="Air Conditioning">
                    <div class="service-info">
                        <h3>Air Conditioning Service</h3>
                        <p>Stay comfortable year-round with our comprehensive AC service. We handle refrigerant recharge, leak detection, and compressor maintenance.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="service-card">
                    <img src="photo\Preventive Maintenance.jpg" alt="Preventive Maintenance">
                    <div class="service-info">
                        <h3>Preventive Maintenance</h3>
                        <p>Avoid costly repairs with our scheduled preventive maintenance plans designed to catch issues before they become serious problems.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-arrow right-arrow" onclick="moveCarousel(1); resetAutoScroll();">&#10095;</div>
    </div>
</section>

<!-- Add this CSS to your existing style section -->
<style>
.scroll-section {
    margin: 2rem auto;
    max-width: 800px;
    padding: 1rem;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.carousel-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    width: 100%;
}

.carousel-content {
    flex: 1;
    overflow: hidden;
    padding: 20px 0;
    position: relative;
    min-height: 300px;
}

.carousel-item {
    position: absolute;
    width: 100%;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.5s ease;
    padding: 0 20px;
    text-align: center;
}

.carousel-item.active {
    opacity: 1;
    transform: translateX(0);
}

.service-card {
    position: relative;
    height: 250px;
    width: 100%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.service-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.service-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 15px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.service-card:hover img {
    transform: scale(1.05);
}

.service-card:hover .service-info {
    transform: translateY(0);
}

.service-info h3 {
    margin: 0 0 10px;
    color: #0073e6;
}

.service-info p {
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
}

.carousel-arrow {
    cursor: pointer;
    font-size: 24px;
    color: #0073e6;
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
}

.carousel-arrow:hover {
    background-color: #0073e6;
    color: white;
}

.carousel-controls {
    display: flex;
    justify-content: center;
    margin-top: 15px;
}

.carousel-controls button {
    background: linear-gradient(145deg,rgb(94, 165, 209),rgb(162, 96, 198));
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s ease;
}

.carousel-controls button:hover {
    background: linear-gradient(145deg,rgb(68, 152, 42),rgb(83, 165, 144));
}
</style>

<!-- Add this JavaScript to handle the carousel functionality with auto-scroll -->
<script>
let currentIndex = 0;
const carouselItems = document.querySelectorAll('.carousel-item');
let autoScrollInterval;
let isAutoScrolling = true;

function moveCarousel(step) {
    // Remove active class from current item
    carouselItems[currentIndex].classList.remove('active');
    
    // Calculate new index
    currentIndex = (currentIndex + step + carouselItems.length) % carouselItems.length;
    
    // Add active class to new current item
    carouselItems[currentIndex].classList.add('active');
}

function startAutoScroll() {
    // Clear any existing intervals first
    clearInterval(autoScrollInterval);
    
    // Set new interval
    autoScrollInterval = setInterval(() => {
        moveCarousel(1);
    }, 5000); // Change slide every 5 seconds
}

function resetAutoScroll() {
    if (isAutoScrolling) {
        clearInterval(autoScrollInterval);
        startAutoScroll();
    }
}

function toggleAutoScroll() {
    if (isAutoScrolling) {
        // Stop auto-scrolling
        clearInterval(autoScrollInterval);
        pauseButton.textContent = '▶️ Play';
        isAutoScrolling = false;
    } else {
        // Resume auto-scrolling
        startAutoScroll();
        pauseButton.textContent = '⏸️ Pause';
        isAutoScrolling = true;
    }
}

// Initialize the carousel
document.addEventListener('DOMContentLoaded', function() {
    // Hide all items initially
    carouselItems.forEach(item => {
        item.classList.remove('active');
    });
    
    // Show the first item
    if (carouselItems.length > 0) {
        carouselItems[0].classList.add('active');
    }
    
    // Start auto-scrolling
    startAutoScroll();
    
    // Add event listeners to pause auto-scrolling when hovering over the carousel
    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseenter', function() {
        if (isAutoScrolling) {
            clearInterval(autoScrollInterval);
        }
    });
    
    carouselContainer.addEventListener('mouseleave', function() {
        if (isAutoScrolling) {
            startAutoScroll();
        }
    });
});
</script>
    <button class="feedback-button" onclick="location.href='feedback.html'">Feedback</button>
    
    <!-- <button class="chatbot" onclick="toggleChatbot()">💬</button> -->
    <!-- <div class="chatbot-popup" id="chatbotPopup">
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
    <script>
    // Variables to track scroll position
    let lastScrollTop = 0;
    const header = document.getElementById('site-header');
    const scrollThreshold = 50; // Minimum scroll amount to trigger header hide/show
    
    // Function to handle scroll events
    window.addEventListener('scroll', function() {
        let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        // Determine scroll direction and apply appropriate class
        if (currentScroll > lastScrollTop && currentScroll > scrollThreshold) {
            // Scrolling down - hide header
            header.classList.add('hide');
        } else {
            // Scrolling up - show header
            header.classList.remove('hide');
        }
        
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
    }, false);
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


<!-- blog section -->

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
        <div class="footer-map">
            <!-- Google Maps Embed -->
            <iframe 
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2750.609666581145!2d77.66778381890838!3d12.846538587509404!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae149285b279d1%3A0x8d1750ebbe9a9c0a!2sNTTF%20Electronics%20%26%20IT!5e0!3m2!1sen!2sin!4v1744014544030!5m2!1sen!2sin"
            width="200" height="150" style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
            </iframe>"
          </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Vehicle Servicing System. All rights reserved.</p>
    </div>
</footer>


</body>
</html>
