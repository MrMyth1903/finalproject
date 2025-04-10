<?php
$con= mysqli_connect('localhost','root','','final');
if(isset($_POST['submit']))

 {
$FirstName=$_POST['firstname'];
$LastName=$_POST['lastname'];
$Phone=$_POST['phone'];
$Mail=$_POST['mail'];
$Pass=$_POST['pass'];
$DOB=$_POST['dob'];
$City=$_POST['city'];

// duplicate value checking
$checkuser="SELECT * from user where Mail='$Mail'";
$re=mysqli_query($con,$checkuser);




if($re->num_rows)
  {
    echo"
    <script>
    alert('User mail address is alredy exist');
    </script>";
    header('refresh:1; url=http://localhost/final year/signup.html');
  }
else
  {
  
$stmt ="INSERT INTO user(FirstName,LastName,Phone,Mail,Password,DOB,City) VALUES('$FirstName','$LastName','$Phone','$Mail','$Pass','$DOB','$City')";
$submit=mysqli_query($con,$stmt);
echo"
    <script>
    alert('Successfully Registered !');
    </script>";
    header('refresh:1; url=http://localhost/final year/index.php');
}
}

?>



