<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php/PHPMailer/PHPMailer-master/src/Exception.php';
require 'php/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'php/PHPMailer/PHPMailer-master/src/SMTP.php';

// Database connection
$conn = new mysqli("localhost", "root", "", "final");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validation
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        die("Please fill in all fields.");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Password strength validation
    if (
        strlen($password) < 8 ||
        strlen($password) > 16 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[^A-Za-z0-9]/', $password)
    ) {
        die("Password does not meet strength requirements.");
    }

    // Update password in plain text (⚠️ Not recommended for production)
    $stmt = $conn->prepare("UPDATE user SET Password = ? WHERE Mail = ?");
    $stmt->bind_param("ss", $password, $email);

    if ($stmt->execute()) {
        // Send confirmation email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'merigaddi0008@gmail.com';  // Replace with your email
            $mail->Password = 'yqvqgtuselknvezr';         // Secure this
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = '🔐 Your Password Has Been Successfully Changed!';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f7f7f7; border-radius: 8px; color: #333;'>
                    <h2 style='color: #2c3e50;'>Hello,</h2>
                    <p style='font-size: 16px;'>This is a confirmation that your account password has been <strong>successfully updated</strong>.</p>

                    <div style='background-color: #ecf0f1; padding: 15px; border-radius: 6px; margin: 20px 0;'>
                        <p style='font-size: 16px; margin: 0;'><strong>🔑 New Password:</strong> <span style='color: #e74c3c;'>$password</span></p>
                    </div>

                    <p style='font-size: 14px;'>If you did not request this password change, please 
                        <a href='mailto:support@merigaddi.com' style='color: #2980b9;'>contact our support team</a> immediately.</p>
                    
                    <p style='margin-top: 30px;'>Regards,<br><strong>Meri Gaddi Team</strong></p>
                    <hr style='margin-top: 20px;'>
                    <p style='font-size: 12px; color: #999;'>This is an automated message. Please do not reply to this email.</p>
                </div>
            ";
            $mail->AltBody = "Hello,\nYour password has been successfully changed.\nNew Password: $password\nIf you did not request this change, contact support immediately.\n- Meri Gaddi Team";

            $mail->send();

            echo "<script>alert('Password updated and confirmation email sent!'); window.location.href='login.html';</script>";
            exit();
        } catch (Exception $e) {
            echo "<script>alert('Password updated, but email could not be sent. Error: " . $mail->ErrorInfo . "'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
