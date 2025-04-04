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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background-color: #218838;
        }
        .back-link {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit User Details</h2>
    <?php if ($user): ?>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" required placeholder="First Name">
        <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" placeholder="Middle Name">
        <input type="text" name="email" value="<?= htmlspecialchars($user['email']) ?>" required placeholder="Last Name">
        <input type="text" name="phoneNumber" value="<?= htmlspecialchars($user['phoneNumber']) ?>" required placeholder="Phone Number">
        <input type="text" name="aadharNo" value="<?= htmlspecialchars($user['aadharNo']) ?>" required placeholder="Aadhar No">
        <input type="text" name="vehicle" value="<?= htmlspecialchars($user['vehicle']) ?>" placeholder="Vehicle No">
        <button type="submit">Update</button>
    </form>
    <?php else: ?>
        <p>User data not available.</p>
    <?php endif; ?>
    <a href="adminindex.php" class="back-link">Back to Admin</a>
</div>
</body>
</html>
