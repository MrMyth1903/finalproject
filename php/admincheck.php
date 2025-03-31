<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email == "merigaddi@gmail.com" && $password == "merigaddi@1903") {
        $_SESSION['admin_email'] = $email; // Start session and store admin email
        header("Location: adminindex.php");
        exit();
    } else {
        echo "Invalid credentials";
    }
}
?>
