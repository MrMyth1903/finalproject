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
            color: red;
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
            background: red;
            border-radius: 8px;
            width: 180px;
            box-shadow: 0 8px 24px rgba(248, 5, 5, 0.15);
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
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border);
        }
        
        .logout-menu-item:last-child {
            border-bottom: none;
            color:red;
        }
        
        .logout-menu-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color:white;
        }
        
        .logout-menu-item:hover {
            background-color:rgb(240, 81, 81);
            padding-left: 20px;
        }
        
        .logout-menu-item.danger {
            color: black;
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
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border);
        }
        
        .logout-menu-item:last-child {
            border-bottom: none;
            color: black;
        }
        
        .logout-menu-item i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color: white;
        }
        
        .logout-menu-item:hover {
            background-color: rgb(240, 81, 81);
            padding-left: 20px;
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
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .data-container {
                padding: 15px;
            }
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
.card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            margin: 20px 0;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--audi-dark);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--audi-red);
            display: inline-block;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .form-col {
            flex: 1;
            padding: 0 15px;
            min-width: 250px;
        }
        
        .form-group {
            margin-bottom: 20px;
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
        
        .service-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .category-tab {
            padding: 10px 20px;
            background-color: #f1f1f1;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .category-tab.active {
            background-color: var(--audi-red);
            color: white;
        }
        
        .service-category {
            display: none;
            margin-top: 20px;
        }
        
        .service-category.active {
            display: block;
        }
        
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .service-checkbox {
            margin-bottom: 10px;
        }
        
        .service-checkbox label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .service-checkbox input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 150px;
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
        
        .quantity-input {
            width: 70px;
            text-align: center;
            border: none;
            padding: 10px 0;
            font-size: 16px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            border-radius: 0;
        }
        
        .price-display {
            background-color: var(--audi-light);
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 16px;
            border-left: 4px solid var(--audi-red);
        }
        
        .price-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-weight: 600;
            font-size: 18px;
        }
        
        .selected-items {
            margin-top: 15px;
        }
        
        .selected-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #ddd;
        }
        
        .submit-button {
            text-align: center;
            margin-top: 30px;
            color: red;
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
        
        .footer {
            text-align: center;
            padding: 20px 0;
            color: #fff;
            font-size: 14px;
        }

        .search-box {
            margin-bottom: 20px;
            position: relative;
        }

        .search-box input {
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .no-results {
            padding: 20px;
            text-align: center;
            color: #777;
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

    <div class="container">
        <div class="selection-container" id="service-selection">
            <h2 class="selection-title">Select Vehicle Service Level</h2>
            <div class="service-level-container">
                <button class="service-level-btn level-1-btn" id="level1Btn">
                    <i class="fas fa-check-circle"></i>
                    Level 1 Service
                    <span>Basic Maintenance<br>₹5000/-</span>

                </button>
                <button class="service-level-btn level-2-btn" id="level2Btn">
                    <i class="fas fa-tools"></i>
                    Level 2 Service
                    <span>Intermediate Service<br>₹10000/-</span>
                </button>
                <button class="service-level-btn level-3-btn" id="level3Btn">
                    <i class="fas fa-cogs"></i>
                    Level 3 Service
                    <span>Comprehensive Service<br>₹25000/-</span>
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
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle"  placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" maxlength="6" minlength="6" placeholder="Enter engine number not more the or less then 6 charcter" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" maxlength="6" minlength="6" placeholder="Enter chasis number not more then or less the 6 character" required>
                </div>
                <input type="hidden" name="price" value="5000">
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
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle" placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" maxlength="6" minlength="6" placeholder="Enter engine number not more then or less then 6 charcter" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" maxlength="6" minlength="6" placeholder="Enter chasis number not more then or less then 6 character" required>
                </div>
                <input type="hidden" name="price" value="10000">
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
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle"  placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" maxlength="6" minlength="6" placeholder="Enter engine number not more the or less then 6 charcter" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" maxlength="6" minlength="6" placeholder="Enter chasis number not more then or less the 6 character" required>
                </div>
                <input type="hidden" name="price" value="25000">
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
                    <input type="text" id="name2" name="email" placeholder="Enter your mail" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="vehicle1">Vehicle Number</label>
                    <input type="text" id="vehicle1" name="vehicle"  placeholder="Enter your vehicle number" required>
                </div>
                <div class="form-group">
                    <label for="engine1">Engine Number</label>
                    <input type="text" id="engine1" name="engine" maxlength="6" minlength="6" placeholder="Enter engine number not more the or less then 6 charcter" required>
                </div>

                <div class="form-group">
                    <label for="chassis1">Chassis Number</label>
                    <input type="text" id="chassis1" name="chassis" maxlength="6" minlength="6" placeholder="Enter chasis number not more then or less the 6 character" required>
                </div>
                <div class="form-group">
                    <label for="phone_number1">Phone Number</label>
                    <input type="text" id="phone_number1" name="phone_number" placeholder="Enter your phone number" required>
                </div>
                    <div class="form-section">
                
                <h2>Service Requirements</h2>
                <div class="service-categories">
                    <div class="category-tab active" data-category="engine">Engine</div>
                    <div class="category-tab" data-category="transmission">Transmission</div>
                    <div class="category-tab" data-category="brakes">Brakes</div>
                    <div class="category-tab" data-category="suspension">Suspension & Steering</div>
                    <div class="category-tab" data-category="electrical">Electrical</div>
                    <div class="category-tab" data-category="cooling">Cooling System</div>
                    <div class="category-tab" data-category="fuel">Fuel System</div>
                    <div class="category-tab" data-category="exhaust">Exhaust System</div>
                    <div class="category-tab" data-category="exterior">Exterior</div>
                    <div class="category-tab" data-category="interior">Interior</div>
                    <div class="category-tab" data-category="maintenance">Regular Maintenance</div>
                </div>
                
                <!-- Engine Category -->
                <div class="service-category active" id="engine-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Engine Control Module"> Engine Control Module</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Timing Belt Kit"> Timing Belt Kit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Engine Mounts"> Engine Mounts</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Crankshaft Sensor"> Crankshaft Position Sensor</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Camshaft"> Camshaft</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Pistons"> Pistons</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Connecting Rods"> Connecting Rods</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Oil Pump"> Oil Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Turbocharger"> Turbocharger</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Intercooler"> Intercooler</label>
                        </div>
                    </div>
                </div>
                
                <!-- Transmission Category -->
                <div class="service-category" id="transmission-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Transmission Assembly"> Transmission Assembly</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Clutch Kit"> Clutch Kit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Flywheel"> Flywheel</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Transmission Fluid"> Transmission Fluid</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Gear Selector"> Gear Selector</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="DSG Mechatronic Unit"> DSG Mechatronic Unit</label>
                        </div>
                    </div>
                </div>
                
                <!-- Brakes Category -->
                <div class="service-category" id="brakes-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Pads"> Brake Pads</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Rotors"> Brake Rotors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Calipers"> Brake Calipers</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="ABS Control Module"> ABS Control Module</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Lines"> Brake Lines</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Master Cylinder"> Brake Master Cylinder</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Shoe Change"> Brake Shoe Change</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Brake Issue"> Brake Issue</label>
                        </div>
                    </div>
                </div>
                
                <!-- Suspension Category -->
                <div class="service-category" id="suspension-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Shock Absorbers"> Shock Absorbers</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Struts"> Struts</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Control Arms"> Control Arms</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Tie Rods"> Tie Rods</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Sway Bar Links"> Sway Bar Links</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Ball Joints"> Ball Joints</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Steering Rack"> Steering Rack</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Power Steering Pump"> Power Steering Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Wheel Bearings"> Wheel Bearings</label>
                        </div>
                    </div>
                </div>
                
                <!-- Electrical Category -->
                <div class="service-category" id="electrical-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Battery"> Battery</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Alternator"> Alternator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Starter Motor"> Starter Motor</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Ignition Coils"> Ignition Coils</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Spark Plugs"> Spark Plugs</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuse Box"> Fuse Box</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Headlight Assembly"> Headlight Assembly</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Tail Light Assembly"> Tail Light Assembly</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Turn Signal Switch"> Turn Signal Switch</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Window Regulator"> Window Regulator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="MMI Control Unit"> MMI Control Unit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Head Light"> Head Light</label>
                        </div>
                    </div>
                </div>
                
                <!-- Cooling Category -->
                <div class="service-category" id="cooling-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Radiator"> Radiator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Water Pump"> Water Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Thermostat"> Thermostat</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Cooling Fan"> Cooling Fan</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Coolant Reservoir"> Coolant Reservoir</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Coolent Change"> Coolant Change</label>
                        </div>
                    </div>
                </div>
                
                <!-- Fuel Category -->
                <div class="service-category" id="fuel-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Pump"> Fuel Pump</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Injectors"> Fuel Injectors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Filter"> Fuel Filter</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fuel Pressure Regulator"> Fuel Pressure Regulator</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Diesel Tank"> Diesel Tank</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Mobile Tank"> Mobile Tank</label>
                        </div>
                    </div>
                </div>
                
                <!-- Exhaust Category -->
                <div class="service-category" id="exhaust-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Catalytic Converter"> Catalytic Converter</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Exhaust Manifold"> Exhaust Manifold</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Muffler"> Muffler</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Oxygen Sensor"> Oxygen Sensor</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Exhaust Pipes"> Exhaust Pipes</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Deeper"> Deeper</label>
                        </div>
                    </div>
                </div>
                
                <!-- Exterior Category -->
                <div class="service-category" id="exterior-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Front Bumper"> Front Bumper</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Rear Bumper"> Rear Bumper</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Hood"> Hood</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Trunk Lid"> Trunk Lid</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Doors"> Doors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Fenders"> Fenders</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Grille"> Grille</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Side Mirrors"> Side Mirrors</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Windshield"> Windshield</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Tire Change"> Tire Change</label>
                        </div>
                    </div>
                </div>
                
                <!-- Interior Category -->
                <div class="service-category" id="interior-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Dashboard"> Dashboard</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Seats"> Seats</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Steering Wheel"> Steering Wheel</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Airbag Module"> Airbag Module</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Climate Control Unit"> Climate Control Unit</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Door Panels"> Door Panels</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Center Console"> Center Console</label>
                        </div>
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Floor Mats"> Floor Mats</label>
                        </div>
                    </div>
                </div>
                
                <!-- Maintenance Category -->
                <div class="service-category" id="maintenance-category">
                    <div class="service-grid">
                        <div class="service-checkbox">
                            <label><input type="checkbox" name="want[]" value="Mobil Change"> Oil Change</label>
                        </div>
                    </div>
                </div>
                
                <div id="search-results" class="service-category">
                    <div class="service-grid" id="search-results-grid">
                        <!-- Search results will appear here -->
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 30px;">
                    <label for="quantity">Quantity</label>
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn minus-btn">-</button>
                        <input type="number" name="quantity" id="quantity" class="quantity-input" value="1" min="1" required>
                        <button type="button" class="quantity-btn plus-btn">+</button>
                    </div>
                </div>
                
                <div class="price-display" id="price-display">
                    <div class="selected-items" id="selected-items">
                        <div>Select services or parts to see the price</div>
                    </div>
                    <div class="price-summary">
                        <span>Total:</span>
                        <span id="total-price">₹0</span>
                    </div>
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
        
        
    </div>

    <script>
        // Price data for each service and part
        const servicePrices = {
            "Tire Change": 500,
            "Mobil Change": 300,
            "Brake Shoe Change": 400,
            "Coolent Change": 350,
            "Brake Issue": 600,
            "Diesel Tank": 450,
            "Mobile Tank": 350,
            "Head Light": 150,
            "Deeper": 1000,
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
            "Transmission Assembly": 45000,
            "Clutch Kit": 15000,
            "Flywheel": 12000,
            "Transmission Fluid": 2500,
            "Gear Selector": 5000,
            "DSG Mechatronic Unit": 30000,
            "Brake Pads": 5000,
            "Brake Rotors": 8000,
            "Brake Calipers": 12000,
            "ABS Control Module": 18000,
            "Brake Lines": 3000,
            "Brake Master Cylinder": 7500,
            "Shock Absorbers": 6000,
            "Struts": 8000,
            "Control Arms": 5000,
            "Tie Rods": 3000,
            "Sway Bar Links": 2000,
            "Ball Joints": 3500,
            "Steering Rack": 16000,
            "Power Steering Pump": 8000,
            "Wheel Bearings": 4000,
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
            "Radiator": 11000,
            "Water Pump": 6000,
            "Thermostat": 2500,
            "Cooling Fan": 5000,
            "Coolant Reservoir": 2000,
            "Fuel Pump": 9000,
            "Fuel Injectors": 8000,
            "Fuel Filter": 1500,
            "Fuel Pressure Regulator": 3500,
            "Catalytic Converter": 22000,
            "Exhaust Manifold": 12000,
            "Muffler": 8000,
            "Oxygen Sensor": 3500,
            "Exhaust Pipes": 6000,
            "Front Bumper": 25000,
            "Rear Bumper": 22000,
            "Hood": 30000,
            "Trunk Lid": 25000,
            "Doors": 35000,
            "Fenders": 18000,
            "Grille": 12000,
            "Side Mirrors": 8000,
            "Windshield": 15000,
            "Dashboard": 45000,
            "Seats": 55000,
            "Steering Wheel": 15000,
            "Airbag Module": 20000,
            "Climate Control Unit": 12000,
            "Door Panels": 8000,
            "Center Console": 10000,
            "Floor Mats": 3000,
        };

        // Reference elements
        const quantityField = document.getElementById('quantity');
        const priceDisplay = document.getElementById('price-display');
        const priceField = document.getElementById('price');
        const checkboxes = document.querySelectorAll('input[name="want[]"]');
        const minusBtn = document.querySelector('.minus-btn');
        const plusBtn = document.querySelector('.plus-btn');

        function updatePrice() {
            const selectedServices = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            const quantity = parseInt(quantityField.value) || 1;
            let totalPrice = 0;
            let priceDetails = '';

            selectedServices.forEach(service => {
                if (service && servicePrices[service]) {
                    const unitPrice = servicePrices[service];
                    totalPrice += unitPrice * quantity;
                    priceDetails += `
                        Item: <span>${service}</span><br>
                        Unit Price: <span>₹${unitPrice.toLocaleString()}</span><br>
                        Quantity: <span>${quantity}</span><br>
                        <div style="font-size: 22px; margin-top: 10px;">
                            Total: <span>₹${(unitPrice * quantity).toLocaleString()}</span>
                        </div>
                    `;
                }
            });

            // Reference to category tabs
const categoryTabs = document.querySelectorAll('.category-tab');
const serviceCategories = document.querySelectorAll('.service-category');

// Function to handle category tab click
categoryTabs.forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        categoryTabs.forEach(t => t.classList.remove('active'));
        // Hide all service categories
        serviceCategories.forEach(category => category.classList.remove('active'));
        
        // Add active class to the clicked tab
        this.classList.add('active');
        
        // Show the corresponding service category
        const selectedCategory = this.getAttribute('data-category');
        document.getElementById(`${selectedCategory}-category`).classList.add('active');
    });
});
            if (totalPrice > 0) {
                priceDisplay.innerHTML = priceDetails + `
                    <div style="font-size: 22px; margin-top: 10px;">
                        Grand Total: <span>₹${totalPrice.toLocaleString()}</span>
                    </div>
                `;
                priceField.value = totalPrice;
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

        // Attach event listeners to checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePrice);
        });

        // Attach event listener for quantity input
        quantityField.addEventListener('input', updatePrice);

        // Initialize price calculation
        updatePrice();
    </script>

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

            // Close the dropdown if clicking outside of it
            window.addEventListener('click', function(event) {
                if (!userEmail.contains(event.target) && !logoutMenu.contains(event.target)) {
                    logoutMenu.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>