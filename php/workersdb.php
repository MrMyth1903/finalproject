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

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    // correct this based on form field
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $aadharNo = $_POST["aadharNo"];

    $sql = "INSERT INTO members (firstname,lastname, email, phoneNumber, aadharNo) 
            VALUES ('$firstname','$lastname', '$email', '$phoneNumber', '$aadharNo')";

    if ($conn->query($sql) === TRUE) {
        // Email setup
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'merigaddi0008@gmail.com';
            $mail->Password = 'yqvqgtuselknvezr'; // Use env variable in production!
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
            $mail->addAddress($email); // send to newly registered user's email
            $mail->Subject = 'Welcome to Meri Gaddi!';
            $mail->Body = "Hi $firstname,\n\nYou have been successfully registered to Meri Gaddi.\n\nThank you!";

            $mail->send();
            echo "<script>alert('User added successfully and email sent!'); window.location.href='adminIndex.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('User added but email could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href='adminIndex.php';</script>";
        }
    } else {
        echo "<script>alert('Database Error: " . $conn->error . "');</script>";
    }
}
?>
