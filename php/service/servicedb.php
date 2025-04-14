<?php
// Database connection
$con = mysqli_connect('localhost', 'root', '', 'final');

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Sanitize input to prevent SQL injection
    $FirstName = mysqli_real_escape_string($con, $_POST['type']);
    $LastName = mysqli_real_escape_string($con, $_POST['vehicle_no']);
    $Email = mysqli_real_escape_string($con, $_POST['email']);
    $Number = mysqli_real_escape_string($con, $_POST['phone']);
    
    // Handle multiple selections for 'want'
    $Phone = mysqli_real_escape_string($con, implode(',', $_POST['want'])); // Convert array to string
    $Pass = intval($_POST['quantity']); // Convert to integer
    $Price = isset($_POST['price']) ? intval($_POST['price']) : 0; // Convert to integer
    $DOB = mysqli_real_escape_string($con, $_POST['address']);

    // Ensure price is valid
    if ($Price > 0) {
        // Insert into database
        $stmt = "INSERT INTO service (V_TYPE, V_NUMBER, EMAIL, PHONE, WANT, QUANTITY, ADDRESS, PRICE) 
                 VALUES ('$FirstName', '$LastName', '$Email', '$Number', '$Phone', '$Pass', '$DOB', '$Price')";

        if (mysqli_query($con, $stmt)) {
            // Order booked successfully
            echo "<script>alert('Successfully Booked!');</script>";

            // Redirect after 1 second
            echo "<script>setTimeout(function() { window.location.href = 'http://localhost/final year/php/payment.php'; }, 1000);</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid Price! Please select a valid service.');</script>";
    }
}

// Close the database connection
mysqli_close($con);
?>