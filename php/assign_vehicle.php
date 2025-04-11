<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "final";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $row and fetch vehicle numbers
$row = null;
$vehicles = [];

// Fetch all vehicle numbers from the appointment table
$vehicle_query = "SELECT vehicle_no FROM appointment";
$vehicle_result = $conn->query($vehicle_query);
if ($vehicle_result) {
    while ($vehicle_row = $vehicle_result->fetch_assoc()) {
        $vehicles[] = $vehicle_row['vehicle_no'];
    }
}

// Fetch user data if ID is passed via GET (for initial form display)
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $user_id = $_POST['id'];
    $vehicle = $_POST['vehicle'];

    // Update vehicle in database
    $sql = "UPDATE members SET vehicle = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $vehicle, $user_id);

    if ($stmt->execute()) {
        // Re-fetch updated user data to get email
        $stmt = $conn->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        $emailTo = $user['email'];
        $subject = "Vehicle Assignment Confirmation";
        $body = "Dear {$user['firstname']} {$user['lastname']},\n\nYour vehicle has been assigned: {$vehicle}.\n\nThank you,\nMeri Gaddi";

        // Send email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'merigaddi0008@gmail.com';
            $mail->Password = 'yqvqgtuselknvezr'; // Use env file or secure method in production
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
            $mail->addAddress($emailTo);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            echo "<script>alert('Vehicle assigned and email sent successfully!'); window.location.href='adminIndex.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        $error_message = "Error assigning vehicle.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Vehicle | Meri Gaddi</title>
    <link rel="stylesheet" href="CSS/stud_reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        :root {
            --primary: #3a36db;
            --primary-dark: #2d2bb0;
            --secondary: #ffc107;
            --dark: #333;
            --light: #f8f9fa;
            --success: #28a745;
            --danger: #dc3545;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .form-container {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            padding: 2.5rem;
            width: 100%;
            max-width: 700px;
            position: relative;
            overflow: hidden;
        }
        
        .form-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .form-header h2 {
            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .form-header p {
            color: #777;
            font-size: 1rem;
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 1rem;
        }
        
        .form-group {
            flex: 1 1 300px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #f8f9fa;
            border: 1px solid #e1e5e8;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(58, 54, 219, 0.1);
        }
        
        .form-control:read-only {
            background-color: #f0f2f5;
            color: #666;
        }
        
        .form-control-icon {
            position: relative;
        }
        
        .form-control-icon .form-control {
            padding-left: 2.8rem;
        }
        
        .form-control-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }
        
        .select-vehicle {
            position: relative;
        }
        
        .select-vehicle select {
            appearance: none;
            padding-right: 2.5rem;
            cursor: pointer;
        }
        
        .select-vehicle::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(58, 54, 219, 0.3);
        }
        
        .btn:active {
            transform: translateY(-1px);
        }
        
        .badge {
            display: inline-block;
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-primary {
            background-color: #e0e0ff;
            color: var(--primary);
        }
        
        .user-info {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary);
        }
        
        .user-info-title {
            font-size: 1.1rem;
            color: #444;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .user-info-title i {
            margin-right: 0.5rem;
            color: var(--primary);
        }
        
        .user-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .user-detail-item {
            flex: 1 1 200px;
            margin-bottom: 0.5rem;
        }
        
        .user-detail-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.25rem;
        }
        
        .user-detail-value {
            font-weight: 500;
            color: #333;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .form-header h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2>Assign Vehicle</h2>
        <p>Update vehicle assignment for member</p>
    </div>
    
    <?php if (isset($error_message)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?= $error_message ?>
    </div>
    <?php endif; ?>
    
    <?php if (isset($success_message)): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> <?= $success_message ?>
    </div>
    <?php endif; ?>

    <?php if ($row): ?>
    <div class="user-info">
        <div class="user-info-title">
            <i class="fas fa-user-circle"></i> Member Information
        </div>
        <div class="user-detail">
            <div class="user-detail-item">
                <div class="user-detail-label">FIRST NAME</div>
                <div class="user-detail-value"><?= htmlspecialchars($row['firstname']) ?></div>
            </div>
            <div class="user-detail-item">
                <div class="user-detail-label">LAST NAME</div>
                <div class="user-detail-value"><?= htmlspecialchars($row['lastname']) ?></div>
            </div>
            <div class="user-detail-item">
                <div class="user-detail-label">EMAIL</div>
                <div class="user-detail-value"><?= htmlspecialchars($row['email']) ?></div>
            </div>
            <div class="user-detail-item">
                <div class="user-detail-label">PHONE</div>
                <div class="user-detail-value"><?= htmlspecialchars($row['phoneNumber']) ?></div>
            </div>
            <div class="user-detail-item">
                <div class="user-detail-label">AADHAR NO.</div>
                <div class="user-detail-value"><?= htmlspecialchars($row['aadharNo']) ?></div>
            </div>
            <?php if (!empty($row['vehicle'])): ?>
            <div class="user-detail-item">
                <div class="user-detail-label">CURRENT VEHICLE</div>
                <div class="user-detail-value">
                    <span class="badge badge-primary"><?= htmlspecialchars($row['vehicle']) ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
        
        <div class="form-group">
            <label for="vehicle">Select Vehicle to Assign</label>
            <div class="select-vehicle">
                <select name="vehicle" id="vehicle" class="form-control" required>
                    <option value="">-- Select Vehicle --</option>
                    <?php 
                    // Display all vehicle numbers from the appointment table
                    foreach ($vehicles as $vehicle_no) {
                        $selected = ($row['vehicle'] == $vehicle_no) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($vehicle_no) . "\" $selected>" . htmlspecialchars($vehicle_no) . "</option>";
                    }
                    ?>
                    <!-- Allow custom entry if needed -->
                    <?php if (!empty($row['vehicle']) && !in_array($row['vehicle'], $vehicles)): ?>
                        <option value="<?= htmlspecialchars($row['vehicle']) ?>" selected><?= htmlspecialchars($row['vehicle']) ?> (Current)</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <button type="submit" name="update" class="btn">
            <i class="fas fa-car-side"></i> Assign Vehicle
        </button>
    </form>
    <?php else: ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> User not found.
    </div>
    <?php endif; ?>
</div>

</body>
</html>