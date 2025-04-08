<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

// DB connection
$host = 'localhost';
$db   = 'final';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// On form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payments'])) {
    $success_count = 0;
    foreach ($_POST['payments'] as $worker_id => $data) {
        $worker_id = intval($worker_id);
        $working_days = intval($data['days']);
        $rate = floatval($data['rate']);

        if ($working_days > 0 && $rate > 0) {
            $amount_paid = $working_days * $rate;

            // Get email and name
            $stmt = $conn->prepare("SELECT email FROM members WHERE id = ?");
            $stmt->bind_param("i", $worker_id);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->fetch();
            $stmt->close();

            if ($email) {
                // Insert payment
                $insert = $conn->prepare("INSERT INTO payments (email, working_days, amount_paid) VALUES (?, ?, ?)");
                $insert->bind_param("sid", $email, $working_days, $amount_paid);
                $insert->execute();
                $insert->close();

                // Prepare & send email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'merigaddi0008@gmail.com'; // Sender email
                    $mail->Password = 'yqvqgtuselknvezr';        // App password
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->isHTML(true);

                    $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
                    $mail->addAddress($email);

                    // Current date
                    $current_date = date("F j, Y");
                    
                    $mail->Subject = 'Payment Confirmation - Meri Gaddi';
                    
                    // Enhanced HTML email template
                    $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>
                        <div style='text-align: center; padding: 10px; background-color: #4CAF50; color: white; border-radius: 5px 5px 0 0;'>
                            <h2>Payment Confirmation</h2>
                        </div>
                        
                        <div style='padding: 20px; background-color: #f9f9f9;'>
                            <p>Dear " . ($email? htmlspecialchars($email) : "Worker") . ",</p>
                            
                            <p>We're pleased to inform you that your payment has been processed successfully.</p>
                            
                            <div style='background-color: white; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #4CAF50;'>
                                <h3 style='margin-top: 0; color: #4CAF50;'>Payment Details</h3>
                                <p><strong>Date:</strong> $current_date</p>
                                <p><strong>Working Days:</strong> $working_days</p>
                                <p><strong>Rate per Day:</strong> ₹$rate</p>
                                <p><strong>Total Amount:</strong> <span style='font-size: 18px; color: #4CAF50;'>₹$amount_paid</span></p>
                            </div>
                            
                            <p>Thank you for your dedication and hard work. We appreciate your valuable contribution to our team.</p>
                            
                            <p>If you have any questions regarding this payment, please don't hesitate to contact us.</p>
                        </div>
                        
                        <div style='text-align: center; padding: 15px; background-color: #f1f1f1; border-radius: 0 0 5px 5px;'>
                            <p style='margin: 0; color: #555;'>Warm Regards,<br>Meri Gaddi Team</p>
                        </div>
                    </div>
                    ";

                    $mail->AltBody = "Dear " . ($email ? $email : "Worker") . ",\n\nYour salary has been credited.\nDate: $current_date\nWorking Days: $working_days\nRate per Day: ₹$rate\nTotal Paid: ₹$amount_paid\n\nThank you for your dedication and hard work.\n\nRegards,\nMeri Gaddi Team";

                    $mail->send();
                    $success_count++;
                } catch (Exception $e) {
                    echo "<script>alert('Email could not be sent to $email. Error: {$mail->ErrorInfo}');</script>";
                }
            }
        }
    }

    if ($success_count > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                showSuccessMessage('$success_count');
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Worker Payment System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #f8f9fa;
            --text-color: #333;
            --border-color: #ddd;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: var(--text-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        
        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
            padding-bottom: 10px;
        }
        
        h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .payment-form {
            padding: 15px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        
        input[type="number"]:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }
        
        .submit-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            margin-top: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: var(--secondary-color);
        }
        
        .pay-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .pay-btn:hover {
            background-color: #0b7dda;
        }
        
        .success-message {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-out;
            z-index: 1000;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .status-icon {
            margin-right: 10px;
        }
        
        @media (max-width: 768px) {
            table {
                width: 100%;
                display: block;
                overflow-x: auto;
            }
            
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-money-check-alt"></i> Worker Payment System</h2>
        
        <div class="payment-form">
            <form method="post">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Worker Email</th>
                            <th><i class="fas fa-calendar-alt"></i> Working Days</th>
                            <th><i class="fas fa-rupee-sign"></i> Daily Rate</th>
                            <th><i class="fas fa-money-bill-wave"></i> Amount</th>
                            <th><i class="fas fa-rupee-sign"></i> Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT id, email FROM members");
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td><input type='number' name='payments[$id][days]' min='0' oninput='calculateAmount($id)'></td>";
                            echo "<td><input type='number' step='0.01' name='payments[$id][rate]' min='0' oninput='calculateAmount($id)'></td>";
                            echo "<td><span id='amount_$id'>₹0.00</span></td>";
                            echo"<td><button type='submit' class='submit-btn'><i class='fas fa-paper-plane'></i> Process Payments</button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Process Payments</button>
            </form>
        </div>
    </div>

    <div class="success-message" id="success-message">
        <i class="fas fa-check-circle status-icon"></i> <span id="message-text"></span>
    </div>

    <script>
        function calculateAmount(workerId) {
            const days = document.querySelector(`input[name="payments[${workerId}][days]"]`).value || 0;
            const rate = document.querySelector(`input[name="payments[${workerId}][rate]"]`).value || 0;
            const amount = days * rate;
            document.getElementById(`amount_${workerId}`).textContent = `₹${amount.toFixed(2)}`;
        }
        
        function showSuccessMessage(count) {
            const messageText = document.getElementById('message-text');
            const noun = count == 1 ? 'payment' : 'payments';
            messageText.textContent = `Successfully processed ${count} ${noun}!`;
            
            const messageElement = document.getElementById('success-message');
            messageElement.style.display = 'block';
            
            setTimeout(() => {
                messageElement.style.display = 'none';
                window.location.href = 'adminindex.php';
            }, 3000);
        }
    </script>
</body>
</html>