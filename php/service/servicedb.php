<?php
$con= mysqli_connect('localhost','root','','final');
if(isset($_POST['submit']))

 {
$FirstName=$_POST['type'];
$LastName=$_POST['vehicle_no'];
$Number=$_POST['phone'];
$Phone=$_POST['want'];
$Mail=$_POST['vendor'];
$Pass=$_POST['quantity'];
$DOB=$_POST['address'];
  
$stmt ="INSERT INTO service(V_TYPE,V_NUMBER,PHONE,WANT,VENDOR,QUANTITY,ADDRESS) VALUES('$FirstName','$LastName','$Number','$Phone','$Mail','$Pass','$DOB')";
$submit=mysqli_query($con,$stmt);
echo"
    <script>
    alert('Successfully Booked !');
    </script>";
    header('refresh:1; url=http://localhost/final year/home.php');
}

?>



