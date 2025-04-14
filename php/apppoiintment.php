<?php  
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer-master/src/Exception.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';

session_start();
if (!isset($_SESSION['email'])) {
    exit("User not logged in.");
}

$emailTo = $_SESSION['email'];

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'final');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $Level = mysqli_real_escape_string($con, $_POST['service_level']);
    $Service_Name = mysqli_real_escape_string($con, $_POST['service']);
    $Date = mysqli_real_escape_string($con, $_POST['date']);
    $Time = mysqli_real_escape_string($con, $_POST['time']);
    $Name = mysqli_real_escape_string($con, $_POST['name']);
    $Email = mysqli_real_escape_string($con, $_POST['email']);
    $Vehicle = mysqli_real_escape_string($con, $_POST['vehicle']);
    $Engien_No = mysqli_real_escape_string($con, $_POST['engine']);
    $Chasis_No = mysqli_real_escape_string($con, $_POST['chassis']);
    $Price = mysqli_real_escape_string($con, $_POST['price']);
    $Phone = mysqli_real_escape_string($con, $_POST['phone_number']);

    // Retrieve selected services
    $selected_services = isset($_POST['want']) ? $_POST['want'] : [];
    $services_string = mysqli_real_escape_string($con, implode(", ", $selected_services));
print_r($services_string);
    $payment_method = "Cash on Delivery";
    $payment_message = "Your appointment is successfully created!<br>Payment will be done at the time of delivery.";

    // Current month check
    $currentMonthStart = date('Y-m-01');
    $currentMonthEnd = date('Y-m-t');
    if ($Date < $currentMonthStart || $Date > $currentMonthEnd) {
        echo "<script>alert('Error: Appointments can only be booked within the current month.'); window.history.back();</script>";
        exit;
    }

    // Time check
    $selectedDateTime = strtotime("$Date $Time");
    $currentDateTime = time();
    if ($selectedDateTime < $currentDateTime) {
        echo "<script>alert('Error: Appointment date and time cannot be in the past.'); window.history.back();</script>";
        exit;
    }

    // Engine/Chassis check
    if (strlen($Engien_No) != 6 || strlen($Chasis_No) != 6) {
        echo "<script>alert('Error: Engine Number and Chassis Number must be exactly 6 characters.'); window.history.back();</script>";
        exit;
    }

    // Duplicate check
    $checkQuery = "SELECT * FROM appointment WHERE SERVICE = ? AND DATE = ? AND TIME = ?";
    $stmtCheck = $con->prepare($checkQuery);
    $stmtCheck->bind_param("sss", $Service_Name, $Date, $Time);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Error: This service is already booked for the selected time slot. Please choose a different service or time.');</script>";
    } else {
        // Insert
        $stmt = $con->prepare("INSERT INTO appointment (LEVEL, SERVICE, DATE, TIME, NAME, EMAIL, VEHICLE_NO, ENGINEE, CHASIS, PRICE, PHONE_NUMBER, SPHERE_PART) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $Level, $Service_Name, $Date, $Time, $Name, $Email, $Vehicle, $Engien_No, $Chasis_No, $Price, $Phone, $services_string);

        if ($stmt->execute()) {
            echo "<script>alert('Appointment successfully created.');</script>";

            // Email content
            $itemList = "
                <tr>
                    <td>$Level</td>
                    <td>$Service_Name</td>
                    <td>$Date</td>
                    <td>$Time</td>
                    <td>$Name</td>
                    <td>$Vehicle</td>
                    <td>$Engien_No</td>
                    <td>$Chasis_No</td>
                    <td>$services_string</td>
                    <td>₹$Price</td>
                    <td>$Phone</td>
                </tr>";

            $body = "
            <div style='font-family: Arial, sans-serif;'>
                <h2 style='color: #0b5394;'>Thank you for choosing <span style='color: #38761d;'>Meri Gaddi</span>!</h2>
                <p>Your appointment has been successfully scheduled. Here are your service details:</p>
                <table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
                    <thead style='background-color: #f2f2f2;'>
                        <tr>
                            <th>LEVEL</th>
                            <th>SERVICE</th>
                            <th>DATE</th>
                            <th>TIME</th>
                            <th>NAME</th>
                            <th>VEHICLE NO</th>
                            <th>ENGINE NO</th>
                            <th>CHASSIS NO</th>
                            <th>SPHERE PART</th>
                            <th>PRICE</th>
                            <th>PHONE</th>
                        </tr>
                    </thead>
                    <tbody>$itemList</tbody>
                </table>
                <p style='color: green;'>$payment_message</p>
                <br>
                <p>If you have any questions, feel free to contact our support team.</p>
                <p>Best regards,<br><strong>Meri Gaddi Team</strong></p>
            </div>";

            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'merigaddi0008@gmail.com';
                $mail->Password = 'yqvqgtuselknvezr';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('merigaddi0008@gmail.com', 'Meri Gaddi');
                $mail->addAddress($emailTo);

                $mail->isHTML(true);
                $mail->Subject = 'Your Meri Gaddi Appointment & Order Details';
                $mail->Body = $body;

                $mail->send();
                echo "<script>alert('Confirmation email sent successfully!'); window.location.href = '../home.php';</script>";
            } catch (Exception $e) {
                echo "<script>alert('Email could not be sent. Error: " . $mail->ErrorInfo . "');</script>";
            }
        } else {
            echo "<script>alert('Error: Unable to create appointment. Please try again.');</script>";
        }

        $stmt->close();
    }

    $stmtCheck->close();
    mysqli_close($con);
}
?>
