<?php
$con= mysqli_connect('localhost','root','','final');
if(isset($_POST['submit']))

 {
$NAME=$_POST['name'];
$EMAIL=$_POST['email'];
$IMAGE=$_POST['image'];
$FEEDBACK=$_POST['feedback'];

$stmt ="INSERT INTO feedback(NAME,EMAIL,IMAGE,FEEDBACK) VALUES('$NAME','$EMAIL','$IMAGE','$FEEDBACK')";
$submit=mysqli_query($con,$stmt);

echo"<script>
alert('Thankyou for your feedback !');
</script>";
header('refresh:1; url=http://localhost/final year/home.php');
 }

?>