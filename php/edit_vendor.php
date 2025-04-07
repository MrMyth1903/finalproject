<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

// Establish database connection
$con = mysqli_connect('localhost', 'root', '', 'final');

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the current user details
    $query = "SELECT * FROM vendor WHERE ID = ?";
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
    $id = intval($_POST['ID']);
    $firstname = trim($_POST['VEN_NAME']);
    $middlename = trim($_POST['AADHAR_NO']);
    $lastname = trim($_POST['EMAIL']);     // Email here
    $phone_no = trim($_POST['ADDRESS']);
    $aadhar_no = trim($_POST['PHONE']);

    if (!ctype_digit($aadhar_no) || strlen($aadhar_no) !== 12) {
        die("Aadhar number must be 12 digits.");
    }

    $updateQuery = "UPDATE vendor SET VEN_NAME=?, AADHAR_NO=?, EMAIL=?, ADDRESS=?, PHONE=? WHERE ID=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("sssssi", $firstname, $middlename, $lastname, $phone_no, $aadhar_no, $id);

    if ($stmt->execute()) {
        // Email sending logic
        $email = $lastname;
        $name = $firstname;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'merigaddi0008@gmail.com';
            $mail->Password = 'yqvqgtuselknvezr'; // Store securely in real projects
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
            $mail->addAddress($email);

            $mail->Subject = 'Welcome to Meri Gaddi';
            $mail->Body = "Dear $name,\n\nYour data has been successfully edited in Meri Gaddi.\n\nRegards,\nMeri Gaddi Team";

            $mail->send();

            echo "
            <script>
                alert('Vendor data edited successfully. Confirmation email sent.');
                window.location.href = 'adminindex.php';
            </script>";
        } catch (Exception $e) {
            echo "
            <script>
                alert('Vendor updated, but email could not be sent. Mailer Error: {$mail->ErrorInfo}');
                window.location.href = 'adminindex.php';
            </script>";
        }
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
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
        <form method="POST" action="">
            <input type="hidden" name="ID" value="<?= htmlspecialchars($user['ID']) ?>">
            <input type="text" name="VEN_NAME" value="<?= htmlspecialchars($user['VEN_NAME']) ?>" required placeholder="First Name">
            <input type="text" name="AADHAR_NO" value="<?= htmlspecialchars($user['AADHAR_NO']) ?>"  placeholder="Middle Name">
            <input type="text" name="EMAIL" value="<?= htmlspecialchars($user['EMAIL']) ?>" required placeholder="Last Name">
            <input type="text" name="ADDRESS" value="<?= htmlspecialchars($user['ADDRESS']) ?>" required placeholder="Phone Number">
            <input type="text" name="PHONE" value="<?= htmlspecialchars($user['PHONE']) ?>" required placeholder="Aadhar No">
            <button type="submit">Update</button>
        </form>
        <a href="adminindex.php" class="back-link">Back to Admin</a>
    </div>
</body>
</html>
