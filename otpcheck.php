<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php/PHPMailer/PHPMailer-master/src/Exception.php';
require 'php/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'php/PHPMailer/PHPMailer-master/src/SMTP.php';

// DB connection
$conn = new mysqli("localhost", "root", "", "final");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Send OTP using PHPMailer
function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'merigaddi0008@gmail.com';
        $mail->Password = 'yqvqgtuselknvezr'; // App password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = '🔐 Your Exclusive Password Reset OTP Awaits!';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px; background-color: #f9f9f9;'>
                <h2 style='color: #333;'>Hello!</h2>
                <p style='font-size: 18px; color: #555;'>We received a request to reset your password. Your OTP is:</p>
                <h1 style='font-size: 24px; color: #007bff;'>$otp</h1>
                <p style='font-size: 14px; color: #888;'>If you didn't request this, please ignore this email.</p>
            </div>
        ";
        $mail->AltBody = "Your OTP is: $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

// Step 1: Request OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $_POST['step'] ?? '';

    if ($step === 'request_otp') {
        $email = $_POST['email'] ?? '';

        if (!empty($email)) {
            $_SESSION['email'] = $email;

            $stmt = $conn->prepare("SELECT * FROM user WHERE Mail = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $otp = rand(1000, 9999);
                $_SESSION['otp'] = $otp;

                if (sendOTP($email, $otp)) {
                    $_SESSION['otp_sent'] = true;
                    echo "<script>alert('OTP sent to your email'); window.location.href='otpcheck.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Failed to send OTP'); window.location.href='otpcheck.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Email not found'); window.location.href='otpcheck.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Please provide an email address'); window.location.href='otpcheck.php';</script>";
            exit();
        }
    }

    // Step 2: Verify OTP
    if ($step === 'verify_otp') {
        $enteredOtp = $_POST['otp'] ?? '';

        if (!empty($enteredOtp) && isset($_SESSION['otp'])) {
            if ($enteredOtp == $_SESSION['otp']) {
                // OTP matched, redirect to home.php
                unset($_SESSION['otp']); // Clear OTP after successful verification
                header("Location: home.php");
                exit();
            } else {
                echo "<script>alert('Invalid OTP. Please try again.'); window.location.href='otpcheck.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('OTP expired or not set. Please request again.'); window.location.href='otpcheck.php';</script>";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification | Meri Gaddi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #2b2d42;
            --light-bg: #f8f9fa;
            --text-dark: #2b2d42;
            --text-light: #6c757d;
            --success: #2ecc71;
            --danger: #e74c3c;
            --white: #ffffff;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            padding: 0 20px;
            flex: 1;
        }
        
        .logo {
            text-align: center;
            padding: 30px 0 10px;
        }
        
        .logo h1 {
            color: var(--primary);
            font-weight: 700;
            margin: 0;
            font-size: 28px;
        }
        
        .logo img {
            height: 50px;
            margin-bottom: 10px;
        }
        
        .card {
            background-color: var(--white);
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: var(--shadow);
        }
        
        .card-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .card-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 10px;
        }
        
        .card-header p {
            color: var(--text-light);
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .input-field {
            position: relative;
        }
        
        .input-field i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--text-light);
        }
        
        .input-field input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .input-field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            outline: none;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: var(--primary);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-icon {
            margin-right: 8px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin: 0 15px;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--text-light);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            font-size: 14px;
        }
        
        .step.active .step-number {
            background-color: var(--primary);
        }
        
        .step-text {
            font-size: 14px;
            color: var(--text-light);
        }
        
        .step.active .step-text {
            color: var(--primary);
            font-weight: 600;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .alert-success {
            background-color: rgba(46, 204, 113, 0.15);
            border-left: 4px solid var(--success);
            color: #27ae60;
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.15);
            border-left: 4px solid var(--danger);
            color: #c0392b;
        }
        
        .alert-icon {
            margin-right: 15px;
            font-size: 18px;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            margin-top: auto;
            color: var(--text-light);
            font-size: 14px;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-light);
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 60px;
            height: 60px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .otp-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
            outline: none;
        }

        .timer {
            text-align: center;
            margin: 10px 0;
            color: var(--text-light);
        }

        @media (max-width: 576px) {
            .card {
                padding: 20px;
            }
            
            .step-text {
                display: none;
            }
            
            .step {
                margin: 0 8px;
            }
            
            .otp-input {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
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

<div class="container">
    <div class="logo">
        <h1>Meri Gaddi</h1>
    </div>
    
    <div class="step-indicator">
        <div class="step active" id="step1-indicator">
            <div class="step-number">1</div>
            <div class="step-text">Email</div>
        </div>
        <div class="step" id="step2-indicator">
            <div class="step-number">2</div>
            <div class="step-text">Verify</div>
        </div>
    </div>
    
    <div class="card" id="emailForm">
        <div class="card-header">
            <h2><i class="fas fa-lock"></i> Login with OTP Password</h2>
            <p>Enter your registered email to receive the verification code</p>
        </div>
        
        <form method="post" action="otpcheck.php">
            <input type="hidden" name="step" value="request_otp">
            
            <div class="form-group">
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter your email address" required>
                </div>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-paper-plane btn-icon"></i> Send Verification Code
            </button>
        </form>
        
        <a href="login.html" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </div>
    
    <div class="card" id="otpForm" style="display: none;">
        <div class="card-header">
            <h2><i class="fas fa-shield-alt"></i> Verify OTP</h2>
            <p>Enter the 4-digit code sent to your email</p>
        </div>
        
        <div id="otpAlert" class="alert alert-success" style="display: none;">
            <i class="fas fa-check-circle alert-icon"></i>
            <span>OTP sent successfully! Check your inbox.</span>
        </div>
        
        <form method="post" action="otpcheck.php" id="verifyOtpForm">
            <input type="hidden" name="step" value="verify_otp">
            <input type="hidden" name="otp" id="completeOtp">
            
            <div class="otp-inputs">
                <input type="text" class="otp-input" maxlength="1" autofocus>
                <input type="text" class="otp-input" maxlength="1">
                <input type="text" class="otp-input" maxlength="1">
                <input type="text" class="otp-input" maxlength="1">
            </div>
            
            <div class="timer">
                <span id="countdown">05:00</span> remaining
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-check-circle btn-icon"></i> Verify Code
            </button>
            
            <button type="button" id="resendBtn" class="btn" style="margin-top: 10px; background-color: transparent; color: var(--primary); border: 1px solid var(--primary);">
                <i class="fas fa-sync-alt btn-icon"></i> Resend Code
            </button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2025 Meri Gaddi. All rights reserved.</p>
</footer>

<script>
// Show the appropriate form based on PHP session
<?php
if (isset($_SESSION['otp_sent']) && $_SESSION['otp_sent']) {
    echo "showOtpForm();";
    echo "document.getElementById('otpAlert').style.display = 'flex';";
}
?>

// Function to show OTP form
function showOtpForm() {
    document.getElementById('emailForm').style.display = 'none';
    document.getElementById('otpForm').style.display = 'block';
    
    // Update step indicators
    document.getElementById('step1-indicator').classList.remove('active');
    document.getElementById('step2-indicator').classList.add('active');
    
    // Start countdown
    startCountdown();
}

// OTP input handling
const otpInputs = document.querySelectorAll('.otp-input');
const completeOtpInput = document.getElementById('completeOtp');

otpInputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
        const value = e.target.value;
        
        if (value.length === 1 && index < otpInputs.length - 1) {
            otpInputs[index + 1].focus();
        }
        
        // Combine all inputs into the hidden field
        let otp = '';
        otpInputs.forEach(input => {
            otp += input.value;
        });
        completeOtpInput.value = otp;
    });
    
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
            otpInputs[index - 1].focus();
        }
    });
});

// Countdown timer for OTP
function startCountdown() {
    let duration = 5 * 60; // 5 minutes in seconds
    const display = document.getElementById('countdown');
    const resendBtn = document.getElementById('resendBtn');
    resendBtn.disabled = true;
    resendBtn.style.opacity = '0.5';
    
    let timer = duration, minutes, seconds;
    let countdown = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(countdown);
            resendBtn.disabled = false;
            resendBtn.style.opacity = '1';
            display.textContent = "00:00";
        }
    }, 1000);
}

// Form Validation
document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
    const otpValue = document.getElementById('completeOtp').value;
    if (otpValue.length !== 4) {
        e.preventDefault();
        alert('Please enter all 4 digits of the OTP');
    }
});

// Reset button for OTP
document.getElementById('resendBtn').addEventListener('click', function() {
    // Here you would typically send a request to resend the OTP
    // For demo purposes, we'll just alert
    alert('Resending OTP...');
    
    // Clear OTP fields
    otpInputs.forEach(input => {
        input.value = '';
    });
    completeOtpInput.value = '';
    
    // Reset and restart countdown
    startCountdown();
    
    // Focus on first input
    otpInputs[0].focus();
});
</script>

</body>
</html>