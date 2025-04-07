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

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch vendor details before deletion
    $stmt = $conn->prepare("SELECT VEN_NAME, EMAIL FROM vendor WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vendor = $result->fetch_assoc();
    $stmt->close();

    if ($vendor) {
        $name = $vendor['VEN_NAME'];
        $email = $vendor['EMAIL'];

        // Delete vendor
        $stmt = $conn->prepare("DELETE FROM vendor WHERE ID = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Send email after successful deletion
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'merigaddi0008@gmail.com';
                $mail->Password = 'yqvqgtuselknvezr'; // Secure this!
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
                $mail->addAddress($email);

                $mail->Subject = 'Farewell from Meri Gaddi';
                $mail->Body = "Dear $name,\n\nThank you for your services. You are no longer part of the Meri Gaddi family.\n\nRegards,\nMeri Gaddi Team";

                $mail->send();
                echo "
                <script>
                    alert('Vendor deleted successfully. Email sent.');
                    window.location.href = 'adminindex.php';
                </script>";
            } catch (Exception $e) {
                echo "
                <script>
                    alert('Vendor deleted, but email could not be sent. Error: {$mail->ErrorInfo}');
                    window.location.href = 'adminindex.php';
                </script>";
            }
        } else {
            echo "
            <script>
                alert('Error deleting vendor.');
                window.location.href = 'adminindex.php';
            </script>";
        }

        $stmt->close();
    } else {
        echo "
        <script>
            alert('Vendor not found.');
            window.location.href = 'adminindex.php';
        </script>";
    }
}

$conn->close();
?>
