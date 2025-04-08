<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "final";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get the member's email before deletion
    $stmt = $conn->prepare("SELECT email FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($emailTo);
    $stmt->fetch();
    $stmt->close();

    if ($emailTo) {
        // Delete the member
        $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'merigaddi0008@gmail.com';
                $mail->Password = 'yqvqgtuselknvezr'; // app-specific password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
                $mail->addAddress($emailTo);

                $mail->Subject = 'Account Deletion Notice';
                $mail->Body = "Dear Worker,\n\nYour account has been removed from our system.\nIf this was a mistake, please contact support.\n\nRegards,\nMeri Gaddi";

                $mail->send();

                header("Location: adminindex.php?msg=delete_success");
                exit();
            } catch (Exception $e) {
                header("Location: adminindex.php?msg=email_error");
                exit();
            }
        } else {
            header("Location: adminindex.php?msg=delete_failed");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: adminindex.php?msg=not_found");
        exit();
    }
}

$conn->close();
?>
