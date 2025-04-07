<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'final');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['vendor_name']);
    $aadhar = mysqli_real_escape_string($conn, $_POST['aadhaar']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $check_query = "SELECT * FROM vendor WHERE AADHAR_NO = '$aadhar' OR EMAIL = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "
        <script>
            alert('Vendor already exists with this Aadhaar or Email.');
            window.location.href = 'adminindex.php';
        </script>";
    } else {
        $insert = "INSERT INTO vendor (VEN_NAME, AADHAR_NO, EMAIL, ADDRESS, PHONE) 
                   VALUES ('$name', '$aadhar', '$email', '$address', '$phone')";

        if (mysqli_query($conn, $insert)) {
            // Send confirmation email
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
                $mail->addAddress($email); // Use the vendor's email

                $mail->Subject = 'Welcome to Meri Gaddi';
                $mail->Body    = "Dear $name,\n\nThank you for registering as a vendor with Meri Gaddi.\n\nRegards,\nMeri Gaddi Team";

                $mail->send();

                echo "
                <script>
                    alert('Vendor added successfully. Confirmation email sent.');
                    window.location.href = 'adminindex.php';
                </script>";
            } catch (Exception $e) {
                echo "
                <script>
                    alert('Vendor added, but email could not be sent. Mailer Error: {$mail->ErrorInfo}');
                    window.location.href = 'adminindex.php';
                </script>";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
