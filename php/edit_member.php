<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

$con = mysqli_connect('localhost', 'root', '', 'final');
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM members WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("User not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['lastname']);
    $lastname = trim($_POST['email']);
    $phone_no = trim($_POST['phoneNumber']);
    $aadhar_no = trim($_POST['aadharNo']);
    $vehicle = trim($_POST['vehicle']);

    if (!ctype_digit($aadhar_no) || strlen($aadhar_no) !== 12) {
        die("Aadhar number must be 12 digits.");
    }

    // Fetch email before updating
    $stmt = $con->prepare("SELECT email FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $email_data = $result->fetch_assoc();
    $stmt->close();
    $emailTo = $email_data['email'];

    // Update user details
    $updateQuery = "UPDATE members SET firstname=?, lastname=?, email=?, phoneNumber=?, aadharNo=?, vehicle=? WHERE id=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("ssssssi", $firstname, $middlename, $lastname, $phone_no, $aadhar_no, $vehicle, $id);

    if ($stmt->execute()) {
        // Send email
        $subject = "User Details Updated";
        $body = "Dear $firstname $lastname,\n\nYour details have been updated successfully.\nAssigned Vehicle: $vehicle\n\nThank you,\nMeri Gaddi";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'merigaddi0008@gmail.com';
            $mail->Password = 'yqvqgtuselknvezr'; // Use env in production
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
            $mail->addAddress($emailTo);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            echo "<script>alert('User updated and email sent successfully!'); window.location.href='adminindex.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch vehicle numbers for dropdown
$vehicles = [];
$vehicle_query = "SELECT vehicle_no FROM appointment";
$vehicle_result = $con->query($vehicle_query);
if ($vehicle_result) {
    while ($vehicle_row = $vehicle_result->fetch_assoc()) {
        $vehicles[] = $vehicle_row['vehicle_no'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Meri Gaddi</title>
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
            padding: 20px;
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
            position: relative;
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
            margin-bottom: 1.5rem;
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
        
        .btn-secondary {
            background-color: #6c757d;
            margin-top: 1rem;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
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
        
        .form-title-icon {
            margin-right: 0.5rem;
            color: var(--primary);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            margin-top: 1rem;
            transition: all 0.2s ease;
        }
        
        .back-link i {
            margin-right: 0.5rem;
        }
        
        .back-link:hover {
            color: var(--primary);
            transform: translateX(-3px);
        }
        
        .field-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 1rem;
            color: #adb5bd;
        }
        
        .form-control-with-icon {
            padding-left: 2.5rem;
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
        <h2><i class="fas fa-user-edit form-title-icon"></i>Edit User Details</h2>
        <p>Update member information and vehicle assignment</p>
    </div>
    
    <?php if ($user): ?>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="firstname"><i class="fas fa-user"></i> First Name</label>
                <input type="text" id="firstname" name="firstname" class="form-control" value="<?= htmlspecialchars($user['firstname']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="lastname"><i class="fas fa-user"></i> Last Name</label>
                <input type="text" id="lastname" name="lastname" class="form-control" value="<?= htmlspecialchars($user['lastname']) ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <div class="form-control-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" class="form-control form-control-with-icon" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="phoneNumber"><i class="fas fa-phone"></i> Phone Number</label>
                <div class="form-control-icon">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control form-control-with-icon" value="<?= htmlspecialchars($user['phoneNumber']) ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="aadharNo"><i class="fas fa-id-card"></i> Aadhar Number</label>
                <div class="form-control-icon">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="aadharNo" name="aadharNo" class="form-control form-control-with-icon" value="<?= htmlspecialchars($user['aadharNo']) ?>" required maxlength="12" pattern="\d{12}" title="Aadhar number must be 12 digits">
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="vehicle"><i class="fas fa-car"></i> Assign Vehicle</label>
            <div class="select-vehicle">
                <select name="vehicle" id="vehicle" class="form-control">
                    <option value="">-- Select Vehicle --</option>
                    <?php 
                    // Display all vehicle numbers from appointment table
                    foreach ($vehicles as $vehicle_no) {
                        $selected = ($user['vehicle'] == $vehicle_no) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($vehicle_no) . "\" $selected>" . htmlspecialchars($vehicle_no) . "</option>";
                    }
                    ?>
                    <?php if (!empty($user['vehicle']) && !in_array($user['vehicle'], $vehicles)): ?>
                        <option value="<?= htmlspecialchars($user['vehicle']) ?>" selected><?= htmlspecialchars($user['vehicle']) ?> (Current)</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn">
            <i class="fas fa-save"></i> Update User
        </button>
        
        <a href="adminindex.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
        </a>
    </form>
    <?php else: ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> User data not available.
    </div>
    <a href="adminindex.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Admin Dashboard
    </a>
    <?php endif; ?>
</div>

</body>
</html>