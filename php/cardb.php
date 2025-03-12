<?php
$con= mysqli_connect('localhost','root','','final');
if(isset($_POST['submit']))

 {
$SERVICE=$_POST['service'];
$DATE=$_POST['date'];
$TIME=$_POST['time'];
$NAME=$_POST['name'];


$stmt ="INSERT INTO car_appointment(SERVICE,DATE,TIME,NAME) VALUES('$SERVICE','$DATE','$TIME','$NAME')";
$submit=mysqli_query($con,$stmt);
echo"<script>
alert('Registration Successfull');
</script>";

 }
 header('refresh:1; url=http://localhost/final year/home.html');
?>