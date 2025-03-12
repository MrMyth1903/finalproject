<?php
$con = mysqli_connect('localhost', 'root', '', 'final');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $Service_Name = mysqli_real_escape_string($con, $_POST['service']);
    $Date = mysqli_real_escape_string($con, $_POST['date']);
    $Time = mysqli_real_escape_string($con, $_POST['time']);
    $Name = mysqli_real_escape_string($con, $_POST['name']);
    $Vehicle = mysqli_real_escape_string($con, $_POST['vehicle']);
    $Want = mysqli_real_escape_string($con, $_POST['want']);
    $Other = isset($_POST['other']) ? mysqli_real_escape_string($con, $_POST['other']) : NULL;  // Handling 'Other' value
    $Phone = mysqli_real_escape_string($con, $_POST['phone_number']);

    // Check for existing appointment with the same service, date, and time
    $checkQuery = "SELECT * FROM appointment WHERE SERVICE = ? AND DATE = ? AND TIME = ?";
    $stmtCheck = $con->prepare($checkQuery);
    $stmtCheck->bind_param("sss", $Service_Name, $Date, $Time);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows > 0) {
        // If an appointment with the same service, date, and time already exists
        echo "<script>alert('Error: This service is already booked for the selected time slot. Please choose a different service or time.');</script>";
    } else {
        // Prepared statement to insert data if no duplication found
        $stmt = $con->prepare("INSERT INTO appointment (SERVICE, DATE, TIME, NAME, VEHICLE_NO, WANT, SPHERE_PART, PHONE_NUMBER) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $Service_Name, $Date, $Time, $Name, $Vehicle, $Want, $Other, $Phone); // Updated to "ssssssss" for 8 params

        // Execute and check for errors
        if ($stmt->execute()) {
            echo "<script>alert('Appointment successfully created.');</script>";
        } else {
            echo "<script>alert('Error: Unable to create appointment. Please try again.');</script>";
        }

        $stmt->close();
    }

    $stmtCheck->close();
}

// Redirect after a short delay to allow alert to be displayed
header('refresh:1; url=http://localhost/final%20year/home.html');

mysqli_close($con);
?>
