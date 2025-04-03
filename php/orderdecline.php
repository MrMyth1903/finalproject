<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

include 'signup.php';

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user email before deleting
    $query = "SELECT EMAIL FROM service WHERE ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['EMAIL'];

        // Prepare the delete statement
        $stmt = $con->prepare("DELETE FROM service WHERE ID = ?");
        $stmt->bind_param("i", $id);

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
            $mail->Subject = "Service Request Canceled!";
            $mail->Body = "Your service request #$email has been canceled.";

            // Send email
            $mail->send();
            
            if ($stmt->execute()) {
                // Redirect with success message
                header("Location: adminindex.php?msg=delete_success");
                exit();
            } else {
                // Redirect with error message
                header("Location: adminindex.php?msg=error");
                exit();
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $stmt->close();
    }
}

$con->close();
?>
