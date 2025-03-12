<?php
// Start the session to track the user after successful login
session_start();

// Include database connection file (assuming you've created this)
//require_once 'signup.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $email = $_POST['username'];
    $pass = $_POST['password'];
    // Check if fields are not empty
    if (!empty($email) && !empty($pass)) {
        // Create a prepared statement to check for the user in the database
        $sql = "SELECT Mail,Password FROM user WHERE Mail='$email'";
       
        $conn = mysqli_connect('localhost','root','','final');
       // $stmt = $conn->prepare($sql);
        $re=mysqli_query($conn,$sql);
        // $stmt->bind_param("s", $email);
        // $stmt->execute();
        // $stmt->store_result();
        
        // Check if the user exists
        if ($re->num_rows > 0) {
            // Bind the result to variables
            // $stmt->bind_result($db_Mail, $db_Password);
            // $stmt->fetch();
            $db_data= mysqli_fetch_array($re,MYSQLI_ASSOC);
            $db_Password = $db_data['Password'];
            $db_Mail  = $db_data['Mail']; 
            // Verify the password
            if($pass == $db_Password) {
                //echo "hello";
                // Password is correct, start a session and redirect
                $_SESSION['email'] = $db_Mail;
                $_SESSION['password'] = $db_Password;
               // print_r($_SESSION['email']);
                header('refresh:1; url=http://localhost/final year/home.html');  // Redirect to a dashboard or home page
                exit();
            } else {
                // Invalid password
                $error = "Incorrect password!";
                header('refresh:0; url=http://localhost/final year/error.html');
            }
        } else {
            // No user found with that email
            $error = "No account found with that email.";
            header('refresh:0; url=http://localhost/final year/error.html');
        }

       
    } else {
        $error = "Please fill in both fields.";
    }
}

$conn->close();
?>