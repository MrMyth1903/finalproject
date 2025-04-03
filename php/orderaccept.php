<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

include 'signup.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user email from the database
    $query = "SELECT EMAIL FROM service WHERE ID = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $email = $row['EMAIL'];

        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'merigaddi0008@gmail.com'; 
            $mail->Password = 'yqvqgtuselknvezr'; // Store this securely
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
            $mail->addAddress($email);

            // Email content
            $mail->Subject = "Service Request Accepted";
            $mail->Body = "Your service request #$email has been accepted. Soon you will receive your accessories.";

            // Send email
            $mail->send();
            header("Location: adminindex.php?msg=accepted");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: No user found with the provided ID.";
    }
}
?>
