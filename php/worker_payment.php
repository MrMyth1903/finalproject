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

            // Get email
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

                // Send email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'merigaddi0008@gmail.com';
                    $mail->Password = 'yqvqgtuselknvezr';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->isHTML(true);

                    $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
                    $mail->addAddress($email);

                    $current_date = date("F j, Y");

                    $mail->Subject = 'Payment Confirmation - Meri Gaddi';
                    $mail->Body = "<div style='font-family: Arial; max-width: 600px; padding: 20px; border: 1px solid #ddd;'>
                        <h2 style='background: #4CAF50; color: white; padding: 10px;'>Payment Confirmation</h2>
                        <p>Dear $email,</p>
                        <p>Your payment has been processed successfully.</p>
                        <p><strong>Date:</strong> $current_date</p>
                        <p><strong>Working Days:</strong> $working_days</p>
                        <p><strong>Rate per Day:</strong> ₹$rate</p>
                        <p><strong>Total Amount:</strong> ₹$amount_paid</p>
                        <p>Thank you for your dedication and hard work.</p>
                        <p>Regards,<br>Meri Gaddi Team</p>
                    </div>";

                    $mail->AltBody = "Your salary has been credited.\nDate: $current_date\nWorking Days: $working_days\nRate per Day: ₹$rate\nTotal Paid: ₹$amount_paid";

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --accent-color: #f39c12;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --text-color: #333;
            --border-radius: 8px;
            --box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa, #e8ecf1);
            color: var(--text-color);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--dark-color);
            font-size: 2.5rem;
            position: relative;
            padding-bottom: 15px;
        }
        
        h2:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        
        h2 i {
            margin-right: 10px;
            color: var(--primary-color);
        }
        
        .payment-form {
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        
        .payment-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        thead {
            background: var(--primary-color);
            color: white;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        tbody tr {
            transition: all 0.3s ease;
        }
        
        tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.1);
        }
        
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            background: #f9f9f9;
            transition: all 0.3s ease;
        }
        
        input[type="number"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: auto;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
        }
        
        .submit-btn:hover {
            background: linear-gradient(135deg, #2980b9, #27ae60);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(46, 204, 113, 0.4);
        }
        
        .submit-btn i {
            margin-right: 8px;
        }
        
        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--secondary-color);
            color: white;
            padding: 15px 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            display: none;
            z-index: 1000;
        }
        
        .status-icon {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .amount-display {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        /* Loading effect */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(52, 152, 219, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Row highlighting */
        .highlight-row {
            animation: highlightFade 1.5s ease;
        }
        
        @keyframes highlightFade {
            0% { background-color: rgba(46, 204, 113, 0.3); }
            100% { background-color: transparent; }
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            
            .container {
                padding: 10px;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            .submit-btn {
                width: 100%;
            }
        }
        
        /* Payment indicator */
        .payment-indicator {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        
        .low {
            background-color: rgba(231, 76, 60, 0.2);
            color: #c0392b;
        }
        
        .medium {
            background-color: rgba(243, 156, 18, 0.2);
            color: #d35400;
        }
        
        .high {
            background-color: rgba(46, 204, 113, 0.2);
            color: #27ae60;
        }
    </style>
</head>
<body>
    <!-- Loading spinner -->
    <div class="loading" id="loading-spinner">
        <div class="spinner"></div>
    </div>

    <div class="container animate__animated animate__fadeIn">
        <h2 class="animate__animated animate__fadeInDown"><i class="fas fa-money-check-alt"></i> Worker Payment System</h2>
        
        <div class="payment-form animate__animated animate__fadeInUp">
            <form method="post" id="payment-form">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Worker Email</th>
                            <th><i class="fas fa-calendar-alt"></i> Working Days</th>
                            <th><i class="fas fa-rupee-sign"></i> Daily Rate</th>
                            <th><i class="fas fa-money-bill-wave"></i> Amount</th>
                            <th><i class="fas fa-chart-line"></i> Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT id, email FROM members");
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $email = $row['email'];
                            $attQuery = $conn->query("SELECT COUNT(*) AS present_days FROM attendance WHERE email = '$email' AND status = 'Present'");
                            $attData = $attQuery->fetch_assoc();
                            $present_days = $attData['present_days'];

                            echo "<tr id='row_$id' class='worker-row'>";
                            echo "<td><span class='worker-email'>" . htmlspecialchars($email) . "</span></td>";
                            echo "<td><input type='number' name='payments[$id][days]' value='$present_days' min='0' oninput='calculateAmount($id)'/></td>";
                            echo "<td><input type='number' step='0.01' name='payments[$id][rate]' value='500' min='0' oninput='calculateAmount($id)'/></td>";
                            echo "<td><span id='amount_$id' class='amount-display'>₹0.00</span></td>";
                            echo"<td><button type='submit' class='submit-btn'><i class='fas fa-paper-plane'></i> Process Payments</button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" class="submit-btn" id="submit-button">
                    <i class="fas fa-paper-plane"></i> Process Payments
                </button>
            </form>
        </div>
    </div>

    <div class="success-message animate__animated animate__fadeInRight" id="success-message">
        <i class="fas fa-check-circle status-icon"></i> <span id="message-text"></span>
    </div>

    <script>
        // Hide loading spinner when page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const loader = document.getElementById('loading-spinner');
                loader.style.opacity = '0';
                setTimeout(function() {
                    loader.style.display = 'none';
                }, 500);
            }, 800);
            
            // Calculate initial amounts
            const workerRows = document.querySelectorAll('.worker-row');
            workerRows.forEach(row => {
                const id = row.id.split('_')[1];
                calculateAmount(id);
            });
        });
        
        function calculateAmount(workerId) {
            const days = document.querySelector(`input[name="payments[${workerId}][days]"]`).value || 0;
            const rate = document.querySelector(`input[name="payments[${workerId}][rate]"]`).value || 0;
            const amount = days * rate;
            
            // Format with commas for thousands
            const formattedAmount = new Intl.NumberFormat('en-IN', { 
                style: 'currency', 
                currency: 'INR',
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }).format(amount).replace('INR', '₹');
            
            document.getElementById(`amount_${workerId}`).textContent = formattedAmount;
            
            // Update status indicator
            updatePaymentStatus(workerId, amount);
            
            // Apply highlight effect
            const row = document.getElementById(`row_${workerId}`);
            row.classList.remove('highlight-row');
            void row.offsetWidth; // Trigger reflow
            row.classList.add('highlight-row');
        }
        
        function updatePaymentStatus(workerId, amount) {
            const statusElement = document.getElementById(`status_${workerId}`);
            statusElement.classList.remove('low', 'medium', 'high');
            
            if (amount <= 0) {
                statusElement.textContent = 'Pending';
                statusElement.classList.add('low');
            } else if (amount < 5000) {
                statusElement.textContent = 'Processing';
                statusElement.classList.add('medium');
            } else {
                statusElement.textContent = 'Ready';
                statusElement.classList.add('high');
            }
        }
        
        function showSuccessMessage(count) {
            const messageText = document.getElementById('message-text');
            const noun = count == 1 ? 'payment' : 'payments';
            messageText.textContent = `Successfully processed ${count} ${noun}!`;

            const messageElement = document.getElementById('success-message');
            messageElement.style.display = 'block';
            messageElement.classList.add('animate__fadeInRight');

            setTimeout(() => {
                messageElement.classList.remove('animate__fadeInRight');
                messageElement.classList.add('animate__fadeOutRight');
                
                setTimeout(() => {
                    messageElement.style.display = 'none';
                    window.location.href = 'adminindex.php';
                }, 500);
            }, 3000);
        }
        
        // Form submission effect
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            const submitButton = document.getElementById('submit-button');
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitButton.disabled = true;
            
            // Show loading effect
            document.getElementById('loading-spinner').style.display = 'flex';
            document.getElementById('loading-spinner').style.opacity = '1';
            
            // Allow the form to continue submission
            // The page will be redirected after processing
        });
    </script>
</body>
</html>